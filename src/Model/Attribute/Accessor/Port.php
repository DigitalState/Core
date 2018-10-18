<?php

namespace Ds\Component\Model\Attribute\Accessor;

/**
 * Trait Port
 *
 * @package Ds\Component\Model
 */
trait Port
{
    /**
     * Set port
     *
     * @param integer $port
     * @return object
     */
    public function setPort(?int $port)
    {
        $this->port = $port;

        return $this;
    }

    /**
     * Get port
     *
     * @return integer
     */
    public function getPort(): ?int
    {
        return $this->port;
    }
}
