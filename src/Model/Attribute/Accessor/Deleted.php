<?php

namespace Ds\Component\Model\Attribute\Accessor;

use DateTime;

/**
 * Trait Deleted
 *
 * @package Ds\Component\Model
 */
trait Deleted
{
    /**
     * Set deleted
     *
     * @param boolean $deleted
     * @return object
     */
    public function setDeleted(?bool $deleted)
    {
        $this->deletedAt = $deleted ? new DateTime : null;

        return $this;
    }

    /**
     * Get deleted
     *
     * @return boolean
     */
    public function getDeleted(): ?bool
    {
        return null !== $this->deletedAt;
    }
}
