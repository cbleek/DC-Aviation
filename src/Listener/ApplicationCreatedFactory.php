<?php

/**
 * Aviation
 *
 * @copyright 2020-2021 Cross Solution <http://cross-solution.de>
 * @license   MIT
 */

declare(strict_types=1);

namespace Aviation\Listener;

use Aviation\Entity\ApplicationStatusMailTemplates;
use Psr\Container\ContainerInterface;

/**
 * Factory for \Aviation\Listener\ApplicationCreated
 *
 * @author Mathias Gelhausen
 * TODO: write tests
 */
class ApplicationCreatedFactory
{
    public function __invoke(
        ContainerInterface $container,
        string $requestedName,
        ?array $options = null
    ): ApplicationCreated {
        $delay = $container->get('config')['aviation_mail_delay']['confirm'] ?? 60;
        return new ApplicationCreated(
            $container->get('Core/MailService'),
            $container->get(ApplicationStatusMailTemplates::class),
            $container->get('repositories')->get('Applications'),
            $delay
        );
    }
}
