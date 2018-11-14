<?php

namespace Ds\Component\Model\Type;

use DateTime;

/**
 * Interface Deletable
 *
 * @package Ds\Component\Model
 */
interface Deletable
{
    /**
     * Set deleted status
     *
     * @param boolean $deleted
     */
    public function setDeleted(?bool $deleted);

    /**
     * Get deleted status
     *
     * @return boolean
     */
    public function getDeleted(): ?bool;

    /**
     * Set deleted at date
     *
     * @param \DateTime $deletedAt
     */
    public function setDeletedAt(DateTime $deletedAt);

    /**
     * Get deleted at date
     *
     * @return \DateTime
     */
    public function getDeletedAt();

    /**
     * Check if deleted or not
     *
     * @return boolean
     */
    public function isDeleted();
}
