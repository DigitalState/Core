<?php

namespace Ds\Component\Model\Attribute\Accessor;

/**
 * Trait Key
 *
 * @package Ds\Component\Model
 */
trait Key
{
    /**
     * Set key
     *
     * @param string $key
     * @return object
     */
    public function setKey(?string $key)
    {
        $this->key = $key;

        return $this;
    }

    /**
     * Get key
     *
     * @return string
     */
    public function getKey(): ?string
    {
        return $this->key;
    }
}
