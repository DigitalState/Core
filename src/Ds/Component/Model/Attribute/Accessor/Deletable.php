<?php

namespace Ds\Component\Model\Attribute\Accessor;

/**
 * Trait Deleted
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
        $this->deleted = $deleted;

        return $this;
    }

    /**
     * Get deleted
     *
     * @return boolean
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

    /**
     * Check if deleted or not
     *
     * @return boolean
     */
    public function isDeleted()
    {
        return $this->deleted;
    }
}
