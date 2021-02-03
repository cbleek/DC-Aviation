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
    public function __construct($options = [])
    {
        parent::__construct($options);
        $this->callbacks = [
            'anrede_formell' => 'getFormalSalutation',
            'salutation_formal' => 'getFormalSalutation',
            'anrede_informell' => 'getInformalSalutation',
            'salutation_informal' => 'getInformalSalutation',
            'job_title' => 'getJobTitle',
            'date' => 'getDate'
        ];
    }

    public static function factory($container, $name, $options = null)
    {
        return new self();
    }
}
