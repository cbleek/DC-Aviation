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
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\DelegatorFactoryInterface;

/**
 * TODO: description
 *
 * @author Mathias Gelhausen
 * TODO: write tests
 */
class ApplicationStatusChangeDelegatorFactory implements DelegatorFactoryInterface
{
    public function __invoke(ContainerInterface $container, $name, callable $callback, ?array $options = null)
    {
        return new ApplicationStatusChangeDelegator(
            $callback(),
            $container->get(ApplicationStatusMailTemplates::class),
            $container->get('Core/MailService'),
            $container->get('Applications/Options')
        );
    }
}
