<?php

/**
 * Aviation
 *
 * @copyright 2020-2021 Cross Solution <http://cross-solution.de>
 * @license   MIT
 */

declare(strict_types=1);

namespace Aviation\Listener;

use Psr\Container\ContainerInterface;

/**
 * Factory for \Aviation\Listener\NotifyRecruitersAndDepartmentManager
 *
 * @author Mathias Gelhausen
 * TODO: write tests
 */
class NotifyRecruitersAndDepartmentManagerFactory
{
    public function __invoke(
        ContainerInterface $container,
        string $requestedName,
        ?array $options = null
    ): NotifyRecruitersAndDepartmentManager {
        return new NotifyRecruitersAndDepartmentManager(
            $container->get('Core/MailService')
        );
    }
}
