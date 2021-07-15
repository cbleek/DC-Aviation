<?php

/**
 * Aviation
 *
 * @copyright 2020-2021 Cross Solution <http://cross-solution.de>
 * @license   MIT
 */

declare(strict_types=1);

namespace Aviation\Form;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\DelegatorFactoryInterface;

/**
 * TODO: description
 *
 * @author Mathias Gelhausen
 * TODO: write tests
 */
class ApplicationsStatusSelectDelegatorFactory implements DelegatorFactoryInterface
{

    public function __invoke(ContainerInterface $container, $name, callable $callback, ?array $options = null)
    {
        /** @var \Core\Form\Element\Select $select */
        $select = $callback();
        $valueOptions = $select->getValueOptions();

        array_shift($valueOptions);
        $valueOptions = array_merge(['all' => 'all'], $valueOptions);

        $select->setValueOptions($valueOptions);

        return $select;
    }
}
