<?php

namespace Ds\Component\Encryption\Model\Attribute\Accessor;

use Ds\Component\Encryption\Model\Type\Encryptable;

/**
 * Trait Encrypt
 *
 * @package Ds\Component\Encryption
 */
trait Encrypt
{
    /**
     * Set encrypt
     *
     * @param boolean $encrypt
     * @return \Ds\Component\Encryption\Model\Type\Encryptable
     */
    public function setEncrypt(bool $encrypt) : Encryptable
    {
        $this->encrypt = $encrypt;

        return $this;
    }

    /**
     * Get encrypt
     *
     * @return boolean
     */
    public function getEncrypt() : bool
    {
        return $this->encrypt;
    }
}
