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

    public function __construct(StatusChange $listener, ApplicationStatusMailTemplates $templates)
    {
        $this->listener = $listener;
        $this->templates = $templates;
    }

    public function prepareFormData(ApplicationEvent $e)
    {
        $this->listener->prepareFormData($e);

        $target = $e->getTarget();
        $data = $target->getFormData();
        $application = $target->getApplicationEntity();
        $organization = $application->getJob()->getOrganization();

        $data['mailText'] = $this->templates->getForOrganization(
            $target->getStatus(),
            $organization
        );

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
