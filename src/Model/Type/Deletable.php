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
     * @return \Ds\Component\Model\Type\Deletable
     */
    public function setDeleted(bool $deleted): Deletable;

    /**
     * Get deleted status
     *
     * @return boolean
     */
    public function getDeleted(): bool;

    /**
     * Set deleted at date
     *
     * @param \DateTime $deletedAt
     * @return \Ds\Component\Model\Type\Deletable
     */
    public function setDeletedAt(DateTime $deletedAt): Deletable;

    /**
     * Get deleted at date
     *
     * @return \DateTime
     */
    public function getDeletedAt(): ?DateTime;

    /**
     * Check if deleted or not
     *
     * @return boolean
     */
    public function isDeleted(): bool;
}
