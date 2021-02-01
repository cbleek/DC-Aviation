<?php

/**
 * Aviation
 *
 * @copyright 2020-2021 Cross Solution <http://cross-solution.de>
 * @license   MIT
 */

declare(strict_types=1);

namespace Aviation\Listener;

use Core\Form\Event\FormEvent;

/**
 * TODO: description
 *
 * @author Mathias Gelhausen
 * TODO: write tests
 */
class RequireDepartmentManagers
{

    public function __invoke(FormEvent $event)
    {
        $managers = $event
            ->getForm()
            ->getForm('general.nameForm')
            ->get('jobCompanyName')
            ->get('managers')
            ->getValue()
        ;

        return
            empty($managers)
            ? 'Es muss mind. ein Abteilungsleiter zugeordnet werden.'
            : false
        ;
    }
}
