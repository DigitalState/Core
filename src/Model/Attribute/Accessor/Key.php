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
    public function setKey($key)
    {
        $this->key = $key;

        return $this;
    }

    /**
     * Get key
     *
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }
}
