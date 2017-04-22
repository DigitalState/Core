<?php

namespace Ds\Component\Model\Accessor;

/**
 * Trait Owner
 */
trait Owner
{
    /**
     * Set owner
     *
     * @param string $owner
     * @return object
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * Get owner
     *
     * @return string
     */
    public function getOwner()
    {
        return $this->owner;
    }
}
