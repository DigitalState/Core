<?php

namespace Ds\Component\Security\Model\Attribute\Accessor;

/**
 * Trait Key
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
