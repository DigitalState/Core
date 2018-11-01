<?php

namespace Ds\Component\Model\Attribute\Accessor;

use DateTime;

/**
 * Trait Timestamp
 *
 * @package Ds\Component\Model
 */
trait Timestamp
{
    /**
     * Set timestamp
     *
     * @param \DateTime $timestamp
     * @return object
     */
    public function setTimestamp(?DateTime $timestamp)
    {
        $this->timestamp = $timestamp;

        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \DateTime
     */
    public function getTimestamp(): ?DateTime
    {
        return $this->timestamp;
    }
}
