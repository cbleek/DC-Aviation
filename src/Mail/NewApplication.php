<?php

/**
 * Aviation
 *
 * @copyright 2020-2021 Cross Solution <http://cross-solution.de>
 * @license   MIT
 */

declare(strict_types=1);

namespace Aviation\Mail;

use Applications\Mail\NewApplication as ApplicationsNewApplication;

/**
 * TODO: description
 *
 * @author Mathias Gelhausen
 * TODO: write tests
 */
class NewApplication extends ApplicationsNewApplication
{
    use StringTemplateHtmlMailTrait;

    public function setVariables($variables = array())
    {
        if (isset($variables['link'])) {
            $variables['link'] = sprintf(
                '<a href="%1$s">%1$s</a>',
                $variables['link']
            );
        }

        return parent::setVariables($variables);
    }
}
