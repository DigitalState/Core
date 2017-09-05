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
    public function setDeleted($deleted)
    {
        $this->deletedAt = $deleted ? new DateTime : null;

        return $this;
    }

    /**
     * Get deleted
     *
     * @return boolean
     */
    public function getDeleted()
    {
        return null !== $this->deletedAt;
    }

    /**
     * Check if deleted
     *
     * @return boolean
     */
    public function isDeleted()
    {
        return null !== $this->deletedAt;
    }
}
