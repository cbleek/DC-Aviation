<?php

/**
 * Aviation
 *
 * @copyright Cross Solution <http://cross-solution.de>
 * @license   MIT
 */

declare(strict_types=1);

namespace Aviation\Validator;

use Applications\Entity\Validator\Application as ApplicationEntityValidator;

/**
 * TODO: description
 *
 * @author Mathias Gelhausen
 * TODO: write tests
 */
class ApplicationValidator extends ApplicationEntityValidator
{
    public function isValid($value)
    {
        return
            parent::isValid($value)
            && $this->checkAttachments($value)
        ;
    }

    private function checkAttachments($value)
    {
        /** @var \Applications\Entity\Application $value */
        if (!$value->getAttachments()->count()) {
            $this->error('NO_ATTACHMENTS');

            return false;
        }

        return true;
    }
}
