<?php
/**
 * Aviation
 *
 * @filesource
 * @license MIT
 */

/** */
namespace Aviation\Mail;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

/**
 * Factory for \Applications\Mail\NewApplication
 *
 * @author Mathias Gelhausen <gelhausen@cross-solution.de>
 * @author Anthonius Munthi <me@itstoni.com>
 * @todo write test
 */
class NewApplicationFactory implements FactoryInterface
{
    private $options = [];

    /**
     * Set creation options
     *
     * @param  array $options
     *
     * @return void
     */
    public function setCreationOptions(array $options)
    {
        $this->options = $options;
    }


    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $options = $options ?: $this->options;
        $router = $container->get('Router');
        $options['router'] = $router;
        $this->setCreationOptions($options);
        return new NewApplication($container->get('ViewManager'), $options);
    }
}
