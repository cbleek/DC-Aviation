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
use Laminas\Mail\Header\ContentType;

/**
 * TODO: description
 *
 * @author Mathias Gelhausen
 * TODO: write tests
 */
class ApplicationStatusChange extends StatusChange
{
    use StringTemplateHtmlMailTrait;

    public function __construct($router, $renderer, $options)
    {
        parent::__construct($router, $options);
        $this->renderer = $renderer;
        $headers = $this->getHeaders();
        $headers->removeHeader('Content-Type');
        $headers->addHeader(ContentType::fromString('Content-Type: text/html; charset=UTF-8'));
        $this->setEncoding('UTF-8');
    }

    protected function getApplicationLink()
    {
        return sprintf(
            '<a href="%1$s">%1$s</a>',
            parent::getApplicationLink()
        );
    }
}
