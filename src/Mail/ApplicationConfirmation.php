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

    protected function getApplicationLink()
    {
        return sprintf(
            '<a href="%1$s">%1$s</a>',
            parent::getApplicationLink()
        );
    }
}
