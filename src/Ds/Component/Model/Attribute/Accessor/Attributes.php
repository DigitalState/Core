<?php

namespace Ds\Component\Model\Attribute\Accessor;

use OutOfRangeException;

/**
 * Trait Attributes
 *
 * @package Ds\Component\Model
 */
trait Attributes
{
    /**
     * Set attributes
     *
     * @param array $attributes
     * @return object
     */
    public function setAttributes($attributes)
    {
        $this->attributes = $attributes;

        return $this;
    }

    /**
     * Get attributes
     *
     * @param string $property
     * @return array
     * @throws \OutOfRangeException
     */
    public function getAttributes($property = null)
    {
        if (null === $property) {
            return $this->attributes;
        }

        if (!array_key_exists($property, $this->attributes)) {
            throw new OutOfRangeException('Array property does not exist.');
        }

        return $this->attributes[$property];
    }
}
