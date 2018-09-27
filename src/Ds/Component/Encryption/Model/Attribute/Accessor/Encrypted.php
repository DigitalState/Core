<?php

namespace Ds\Component\Encryption\Model\Attribute\Accessor;

/**
 * Trait Encrypted
 *
 * @package Ds\Component\Encryption
 */
trait Encrypted
{
    /**
     * Set encrypted status
     *
     * @param boolean $encrypted
     * @return object
     */
    public function setEncrypted(bool $encrypted)
    {
        $this->encrypted = $encrypted;

        return $this;
    }

    /**
     * Get encrypted status
     *
     * @return boolean
     */
    public function getEncrypted()
    {
        return $this->encrypted;
    }
}
