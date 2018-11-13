<?php

namespace Ds\Component\Formio\Model\Attribute;

/**
 * Trait Owner
 *
 * @package Ds\Component\Formio
 */
trait Owner
{
    /**
     * @var string
     */
    private $owner; # region accessors

    /**
     * Set owner
     *
     * @param string $owner
     * @return object
     */
    public function setOwner(?string $owner)
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * Get owner
     *
     * @return string
     */
    public function getOwner(): ?string
    {
        return $this->owner;
    }

    # endregion
}
