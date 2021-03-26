<?php

/**
 * Aviation
 *
 * @copyright 2020-2021 Cross Solution <http://cross-solution.de>
 * @license   MIT
 */

declare(strict_types=1);

namespace Aviation\Mail;

use Psr\Container\ContainerInterface;

/**
 * Factory for \Aviation\Mail\ApplicationStatusChange
 *
 * @author Mathias Gelhausen
 * TODO: write tests
 */
class ApplicationStatusChangeFactory
{
    public function __invoke(
        ContainerInterface $container,
        string $requestedName,
        ?array $options = null
    ): ApplicationStatusChange {
        return new ApplicationStatusChange(
            $container->get('Router'),
            $container->get('ViewManager'),
            $options ?? []
        );
    }
}
