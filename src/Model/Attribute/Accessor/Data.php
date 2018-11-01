<?php

namespace Ds\Component\Model\Attribute\Accessor;

use OutOfRangeException;

/**
 * Trait Data
 *
 * @package Ds\Component\Model
 */
trait Data
{
    /**
     * Set data
     *
     * @param array $data
     * @return object
     */
    public function setData(?array $data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Get data
     *
     * @param string $property
     * @return array
     * @throws \OutOfRangeException
     */
    public function getData(?string $property)
    {
        if (null === $property) {
            return $this->data;
        }

        if (!array_key_exists($property, $this->data)) {
            throw new OutOfRangeException('Array property does not exist.');
        }

        return $this->data[$property];
    }
}
