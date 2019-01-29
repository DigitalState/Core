<?php

namespace Ds\Component\Translation\Validator\Constraints;

use Ds\Component\Translation\Validator\ValidValidator;
use Symfony\Component\Validator\Constraint;

/**
 * Class Valid
 *
 * @package Ds\Component\Translation
 * @Annotation
 */
final class Valid extends Constraint
{
    /**
     * Get message
     *
     * @return string
     */
    public function getMessage()
    {
        return 'The translations must be valid.';
    }

    /**
     * {@inheritdoc}
     */
    public function validatedBy()
    {
        return ValidValidator::class;
    }

    /**
     * {@inheritdoc}
     */
    public function getTargets()
    {
        return static::CLASS_CONSTRAINT;
    }
}
