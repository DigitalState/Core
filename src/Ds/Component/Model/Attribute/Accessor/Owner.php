<?php

namespace Ds\Component\Model\Attribute\Accessor;

use DomainException;

/**
 * Trait Owner
 *
 * @package Ds\Component\Model
 */
trait Owner
{
    /**
     * Set owner
     *
     * @param string $owner
     * @return object
     * @throws \DomainException
     */
    public function setOwner($owner)
    {
        if (null !== $owner) {
            if (!preg_match('/^[a-z]+$/i', $owner)) {
                throw new DomainException('Owner is not valid.');
            }
        }

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
