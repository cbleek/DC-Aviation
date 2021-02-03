<?php

/**
 * Aviation
 *
 * @copyright 2020-2021 Cross Solution <http://cross-solution.de>
 * @license   MIT
 */

declare(strict_types=1);

namespace Aviation\Mail;

use Psr\Container\ContainerInterface;

/**
 * Factory for \Aviation\Mail\StringTemplateHtmlMail
 *
 * @author Mathias Gelhausen
 * TODO: write tests
 */
class StringTemplateHtmlMailFactory
{
    private $mailMap = [
        'Applications/NewApplication' => NewApplication::class,
    ];

    public function __invoke(
        ContainerInterface $container,
        string $requestedName,
        ?array $options = null
    ): object {
        $mailClass = $this->mailMap[$requestedName] ?? $requestedName;

        return new $mailClass(
            $container->get('ViewManager'),
            $options ?? []
        );
    }
}
