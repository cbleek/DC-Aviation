<?php

/**
 * Aviation
 *
 * @copyright 2020-2021 Cross Solution <http://cross-solution.de>
 * @license   MIT
 */

declare(strict_types=1);

namespace Aviation\Listener;

use Applications\Listener\Events\ApplicationEvent;
use Applications\Listener\StatusChange;
use Aviation\Entity\ApplicationStatusMailTemplates;
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

    public function __construct(
        StatusChange $listener,
        ApplicationStatusMailTemplates $templates,
        MailService $mails
    ) {
        $this->listener = $listener;
        $this->templates = $templates;
        $this->mails = $mails;
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
        $this->listener->sendMail($event);
    }

}
