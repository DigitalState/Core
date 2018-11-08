<?php

namespace Ds\Component\Encryption\Model\Attribute\Accessor;

/**
 * Trait Encrypt
 *
 * @package Ds\Component\Encryption
 */
trait Encrypt
{
    /**
     * Set encrypt instruction
     *
     * @param boolean $encrypt
     * @return object
     */
    public function setEncrypt(bool $encrypt)
    {
        $this->encrypt = $encrypt;

        return $this;
    }

    /**
     * Get encrypt instruction
     *
     * @return boolean
     */
    public function getEncrypt(): bool
    {
        return $this->encrypt;
    }
}
