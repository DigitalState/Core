<?php

namespace Ds\Component\Model\Type;

use DateTime;

/**
 * Interface Deletable
 */
interface Deletable
{
    /**
     * Set deleted status
     *
     * @param boolean $deleted
     * @return object
     */
    public function setDeleted($deleted);

    /**
     * Get deleted status
     *
     * @return boolean
     */
    public function getDeleted();

    /**
     * Set deleted at date
     *
     * @param \DateTime $deletedAt
     * @return object
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
