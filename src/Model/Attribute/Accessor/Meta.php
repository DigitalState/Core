<?php

namespace Ds\Component\Model\Attribute\Accessor;

use OutOfRangeException;

/**
 * Trait Meta
 *
 * @package Ds\Component\Model
 */
trait Meta
{
    /**
     * Set meta
     *
     * @param array $meta
     * @return object
     */
    public function setMeta($meta)
    {
        $this->meta = $meta;

        return $this;
    }

    /**
     * Get meta
     *
     * @param string $property
     * @return array
     * @throws \OutOfRangeException
     */
    public function getMeta($property = null)
    {
        if (null === $property) {
            return $this->meta;
        }

        if (!array_key_exists($property, $this->meta)) {
            throw new OutOfRangeException('Array property does not exist.');
        }

        return $this->meta[$property];
    }
}
