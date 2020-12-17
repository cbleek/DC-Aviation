<?php

declare(strict_types=1);

namespace Aviation\Listener;

use Core\Form\Event\FormEvent;

class JobContainerInitListener
{
    public function __invoke(FormEvent $event)
    {
        $jobContainer = $event->getForm();
        $jobContainer->disableForm('general.portalForm');
        $jobContainer->disableForm('general.customerNote');
        $jobContainer->disableForm('general.salaryForm');
    }
}
