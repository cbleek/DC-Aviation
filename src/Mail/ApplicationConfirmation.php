<?php

/**
 * Aviation
 *
 * @copyright 2020-2021 Cross Solution <http://cross-solution.de>
 * @license   MIT
 */

declare(strict_types=1);

namespace Aviation\Mail;

use Applications\Mail\Confirmation;

/**
 * TODO: description
 *
 * @author Mathias Gelhausen
 * TODO: write tests
 */
class ApplicationConfirmation extends Confirmation
{
    use StringTemplateHtmlMailTrait;

    protected function initCallbacks()
    {
        $this->callbacks = [
            'anrede_formell' => 'getFormalSalutation',
            'salutation_formal' => 'getFormalSalutation',
            'anrede_informell' => 'getInformalSalutation',
            'salutation_informal' => 'getInformalSalutation',
            'job_title' => 'getJobTitle',
            'date' => 'getDate',
            'link' => 'getApplicationLink',
        ];
    }

    protected function getApplicationLink()
    {
        return sprintf(
            '<a href="%1$s">%1$s</a>',
            parent::getApplicationLink()
        );
    }
}
