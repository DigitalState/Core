<?php

namespace Ds\Component\Model\Attribute\Accessor;

/**
 * Trait Identifier
 *
 * @package Ds\Component\Model
 */
trait Identifier
{
    /**
     * Set identifier
     *
     * @param string $identifier
     * @return object
     */
    public function setIdentifier(?string $identifier)
    {
        $this->identifier = $identifier;

        return $this;
    }

    /**
     * Get identifier
     *
     * @return string
     */
    public function getIdentifier(): ?string
    {
        return $this->identifier;
    }
}
