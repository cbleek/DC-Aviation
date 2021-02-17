<?php

/**
 * Aviation
 *
 * @copyright 2020-2021 Cross Solution <http://cross-solution.de>
 * @license   MIT
 */

declare(strict_types=1);

namespace Aviation\Form\View\Helper;

use Core\Form\View\Helper\FormInfoCheckbox;
use Laminas\Form\ElementInterface;

/**
 * Workaround for the lack of config-option in YAWIK
 *
 * remove when implemented in yawik along with the delegator factory.
 *
 * @author Mathias Gelhausen
 * TODO: write tests
 */
class AviationInfoCheckbox extends FormInfoCheckbox
{
    public function render(ElementInterface $element)
    {
        $rendered = parent::render($element);

        if (($href = $element->getOption('url'))) {
            $rendered = preg_replace('~data-toggle="modal" href="[^"]*" data-target="[^"]*"~s', 'target="_blank" href="' . $href . '"', $rendered);
        }

        return $rendered;
    }
}
