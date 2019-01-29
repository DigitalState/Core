<?php

namespace Ds\Component\Model\Attribute\Accessor;

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
    public function setAttributes(?array $attributes)
    {
        $this->attributes = $attributes;

        return $this;
    }

    /**
     * Get attributes
     *
     * @return array
     */
    public function getAttributes(): ?array
    {
        return $this->attributes;
    }
}
