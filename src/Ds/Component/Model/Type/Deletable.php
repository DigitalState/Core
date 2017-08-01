<?php

namespace Ds\Component\Model\Type;

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
     * Check if deleted or not
     *
     * @return boolean
     */
    public function isDeleted();
}
