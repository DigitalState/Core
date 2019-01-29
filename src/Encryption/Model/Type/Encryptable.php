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
     */
    public function setEncrypted(bool $encrypted);

    /**
     * Get encrypted status
     *
     * @return boolean
     */
    public function getEncrypted(): bool;
}
