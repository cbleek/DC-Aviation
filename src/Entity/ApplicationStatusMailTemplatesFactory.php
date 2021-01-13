<?php

/**
 * Aviation
 *
 * @copyright 2020-2021 Cross Solution <http://cross-solution.de>
 * @license   MIT
 */

declare(strict_types=1);

namespace Aviation\Entity;

use Psr\Container\ContainerInterface;

/**
 * Factory for \Aviation\Entity\ApplicationStatusMailTemplates
 *
 * @author Mathias Gelhausen
 * TODO: write tests
 */
class ApplicationStatusMailTemplatesFactory
{
    public function __invoke(
        ContainerInterface $container,
        string $requestedName,
        ?array $options = null
    ): ApplicationStatusMailTemplates {
        $config = $container->get('config')['aviation_mail_templates']['language_map'] ?? [];

        return new ApplicationStatusMailTemplates($config);
    }
}
