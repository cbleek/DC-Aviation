<?php

/**
 * Aviation
 *
 * @copyright 2020-2021 Cross Solution <http://cross-solution.de>
 * @license   MIT
 */

declare(strict_types=1);

namespace Aviation\Mail;

use Applications\Mail\StatusChange;

/**
 * TODO: description
 *
 * @author Mathias Gelhausen
 * TODO: write tests
 */
class ApplicationsFixedStatusChange extends StatusChange
{
    public static function factory($container, $name, $options = null)
    {
        return new self(
            $container->get('Router'),
            $options ?? []
        );
    }
}
