<?php

/**
 * Aviation
 *
 * @copyright 2020-2021 Cross Solution <http://cross-solution.de>
 * @license   MIT
 */

declare(strict_types=1);

namespace Aviation\Listener;

use Applications\Entity\StatusInterface;
use Applications\Listener\Events\ApplicationEvent;
use Applications\Repository\Application;
use Aviation\Entity\ApplicationStatusMailTemplates;
use Aviation\Mail\ApplicationConfirmation;
use Core\Mail\MailService;


/**
 * TODO: description
 *
 * @author Mathias Gelhausen
 * TODO: write tests
 */
class ApplicationCreated
{

    protected $mails;
    protected $delay = 0;
    protected $templates;

    public function __construct(MailService $mails, ApplicationStatusMailTemplates $templates, Application $repository, int $delay = 0)
    {
        $this->mails = $mails;
        $this->templates = $templates;
        $this->repository = $repository;
        $this->delay = $delay;
    }

    public function __invoke(ApplicationEvent $event)
    {
        $application = $event->getApplicationEntity();
        $organization = $application->getJob()->getOrganization();
        [$body, $subject] = $this->templates->getForOrganization(StatusInterface::CONFIRMED, $organization);

        $mail = $this->mails->build(
            ApplicationConfirmation::class,
            [
                'application' => $application,
                'body' => $body,
            ]
        );
        $mail->setSubject(sprintf($subject, strftime('%x', $application->getDateCreated()->getTimestamp())), false);
        $this->mails->queue($mail, ['delay' => $this->delay]);

        $application->changeStatus(
            StatusInterface::CONFIRMED,
            sprintf('Mail was sent to %s', $application->getContact()->getEmail())
        );

        $this->repository->store($application);
    }
}
