<?php

/**
 * Aviation
 *
 * @copyright 2020-2021 Cross Solution <http://cross-solution.de>
 * @license   MIT
 */

declare(strict_types=1);

namespace Aviation\Listener;

use Applications\Entity\Application;
use Applications\Entity\StatusInterface;
use Applications\Listener\Events\ApplicationEvent;
use Applications\Listener\StatusChange;
use Applications\Options\ModuleOptions;
use Aviation\Entity\ApplicationStatusMailTemplates;
use Aviation\Mail\ApplicationStatusChange;
use Core\Mail\MailService;

/**
 * TODO: description
 *
 * @author Mathias Gelhausen
 * TODO: write tests
 */
class ApplicationStatusChangeDelegator
{

    private $listener;
    private $templates;
    private $mails;
    private $options;

    public function __construct(
        StatusChange $listener,
        ApplicationStatusMailTemplates $templates,
        MailService $mails,
        ModuleOptions $options
    ) {
        $this->listener = $listener;
        $this->templates = $templates;
        $this->mails = $mails;
        $this->options = $options;
    }

    public function prepareFormData(ApplicationEvent $e)
    {
        $this->listener->prepareFormData($e);

        $target = $e->getTarget();
        $data = $target->getFormData();
        $application = $target->getApplicationEntity();
        $organization = $application->getJob()->getOrganization();
        $mail = $this->mails->get('Applications/StatusChange');
        [$mailText, $mailSubject] = $this->templates->getForOrganization(
            $target->getStatus(),
            $organization
        );

        $mail->setBody($mailText);
        $mail->setApplication($application);

        $mailText = $mail->getBodyText();
        $mailSubject = sprintf(
            $mailSubject,
            strftime('%x', $application->getDateCreated()->getTimestamp())
        );

        $data['mailText'] = $mailText;
        $data['mailSubject'] = $mailSubject;

        $target->setFormData($data);
    }

     /**
     * Sends the Notification Mail.
     *
     * @param ApplicationEvent $event
     */
    public function sendMail(ApplicationEvent $event)
    {
        $event = $event->getTarget();
        if (!$event->isPostRequest()) {
            return;
        }

        $application = $event->getApplicationEntity();
        $status = $event->getStatus();
        $user = $event->getUser();
        $post = $event->getPostData();

        $settings = $user->getSettings('Applications');
        $recipient = $this->getRecipient($application, $status);
        /* @var \Applications\Mail\StatusChange $mail */
        $mail = $this->mails->get(ApplicationStatusChange::class);

        $mail->setSubject($post['mailSubject']);
        $mail->setBody($post['mailText']);
        $mail->setTo($recipient);

        if ($from = $application->getJob()->getContactEmail()) {
            $mail->setFrom($from, $application->getJob()->getCompany());
        }

        if ($settings->mailBCC) {
            $mail->addBcc($user->getInfo()->getEmail(), $user->getInfo()->getDisplayName());
        }
        $job = $application->getJob();
        $jobUser = $job->getUser();
        if ($jobUser->getId() != $user->getId()) {
            $jobUserSettings = $jobUser->getSettings('Applications');
            if ($jobUserSettings->getMailBCC()) {
                $mail->addBcc($jobUser->getInfo()->getEmail(), $jobUser->getInfo()->getDisplayName(false));
            }
        }

        $org = $job->getOrganization()->getParent(/*returnSelf*/ true);
        $orgUser = $org->getUser();
        if ($orgUser->getId() != $user->getId() && $orgUser->getId() != $jobUser->getId()) {
            $orgUserSettings = $orgUser->getSettings('Applications');
            if ($orgUserSettings->getMailBCC()) {
                $mail->addBcc($orgUser->getInfo()->getEmail(), $orgUser->getInfo()->getDisplayName(false));
            }
        }

        if ($this->options->getDelayApplicantRejectMail()
            && $status == StatusInterface::REJECTED
        ) {
            $this->mails->queue($mail, [ 'delay' => $this->options->getDelayApplicantRejectMail() ]);
        } else {
            $this->mails->send($mail);
        }


        $historyText = sprintf('E-Mail gesendet an %s', key($recipient) ?: $recipient[0]);
        $application->changeStatus($status, $historyText);
        $event->setNotification($historyText);
    }

     /**
     * @param Application $application
     * @param             $status
     *
     * @return array
     */
    protected function getRecipient(Application $application, $status)
    {
        $recipient = StatusInterface::ACCEPTED == $status
            ? $application->getJob()->getUser()->getInfo()
            : $application->getContact();

        $email = $recipient->getEmail();
        $name  = $recipient->getDisplayName(false);

        return $name ? [ $email => $name ] : [ $email ];
    }
}
