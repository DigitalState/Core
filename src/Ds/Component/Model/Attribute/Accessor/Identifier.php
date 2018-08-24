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
    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;

        return $this;
    }

    /**
     * Get identifier
     *
     * @return string
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }
}
