<?php

namespace Ds\Component\Security\Model\Attribute\Accessor;

/**
 * Trait Type
 *
 * @package Ds\Component\Security
 */
trait Type
{
    /**
     * Set type
     *
     * @param string $type
     * @return object
     */
    public function setType(?string $type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType(): ?string
    {
        return $this->type;
    }
}
