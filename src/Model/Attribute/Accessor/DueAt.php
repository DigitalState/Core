<?php

namespace Ds\Component\Model\Attribute\Accessor;

use DateTime;

/**
 * Trait DueAt
 *
 * @package Ds\Component\Model
 */
trait DueAt
{
    /**
     * Set due at date
     *
     * @param \DateTime $dueAt
     * @return object
     */
    public function setDueAt(?DateTime $dueAt)
    {
        $this->dueAt = $dueAt;

        return $this;
    }

    /**
     * Get due at date
     *
     * @return \DateTime
     */
    public function getDueAt(): ?DateTime
    {
        return $this->dueAt;
    }
}
