<?php

namespace Ds\Component\Encryption\Model\Type;

/**
 * Interface Encryptable
 *
 * @package Ds\Component\Encryption
 */
interface Encryptable
{
    /**
     * Set encrypted status
     *
     * @param boolean $encrypted
     * @return \Ds\Component\Encryption\Model\Type\Encryptable
     */
    public function setEncrypted(bool $encrypted) : Encryptable;

    /**
     * Get encrypted status
     *
     * @return boolean
     */
    public function getEncrypted() : bool;
}
