<?php

namespace Ds\Component\Model\Attribute\Accessor;

/**
 * Trait Primary
 *
 * @package Ds\Component\Model
 */
trait Primary
{
    /**
     * Set primary
     *
     * @param boolean $primary
     * @return object
     */
    public function setPrimary(?bool $primary)
    {
        $this->primary = $primary;

        return $this;
    }

    /**
     * Get primary
     *
     * @return boolean
     */
    public function getPrimary(): ?bool
    {
        return $this->primary;
    }

    /**
     * Check if primary or not
     *
     * @return boolean
     */
    public function isPrimary(): bool
    {
        return $this->primary;
    }
}
