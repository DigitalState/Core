<?php

namespace Ds\Component\Model\Attribute\Accessor;

/**
 * Trait Ip
 *
 * @package Ds\Component\Model
 */
trait Ip
{
    /**
     * Set ip
     *
     * @param string $ip
     * @return object
     */
    public function setIp(?string $ip)
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * Get ip
     *
     * @return string
     */
    public function getIp(): ?string
    {
        return $this->ip;
    }
}
