<?php

namespace Ds\Component\Model\Attribute\Accessor;

/**
 * Trait Host
 *
 * @package Ds\Component\Model
 */
trait Host
{
    /**
     * Set host
     *
     * @param string $host
     * @return object
     */
    public function setHost(?string $host)
    {
        $this->host = $host;

        return $this;
    }

    /**
     * Get host
     *
     * @return string
     */
    public function getHost(): ?string
    {
        return $this->host;
    }
}
