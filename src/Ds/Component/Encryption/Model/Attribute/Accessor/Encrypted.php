<?php

namespace Ds\Component\Encryption\Model\Attribute\Accessor;

use Ds\Component\Encryption\Model\Type\Encryptable;

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
     * @return \Ds\Component\Encryption\Model\Type\Encryptable
     */
    public function setEncrypted(bool $encrypted) : Encryptable
    {
        $this->encrypted = $encrypted;

        return $this;
    }

    /**
     * Get encrypted status
     *
     * @return boolean
     */
    public function getEncrypted() : bool
    {
        return $this->encrypted;
    }
}
