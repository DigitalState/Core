<?php

namespace Ds\Component\Formio\Exception;

use Exception;

/**
 * Class ValidationException
 *
 * @package Ds\Component\Formio
 */
final class ValidationException extends Exception
{
    /**
     * @var array
     */
    private $errors; # region accessors

    /**
     * Set errors
     *
     * @param array $errors
     * @return \Ds\Component\Formio\Exception\ValidationException
     */
    public function setErrors(array $errors)
    {
        $this->errors = $errors;

        return $this;
    }

    /**
     * Get errors
     *
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    # endregion
}
