<?php
/**
 * Yawik DemoSkin
 */

/**  */
namespace Aviation\Factory\Dependency;

use Aviation\Dependency\Manager;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

/**
 *
 *
 * @author Mathias Gelhausen <gelhausen@cross-solution.de>
 */
class ManagerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $manager = new Manager(
            $container->get('Core/DocumentManager')
        );
        $manager->setEventManager(
            $container->get('Auth/Dependency/Manager/Events')
        );

        return $manager;
    }
}
