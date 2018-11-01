<?php

namespace Ds\Component\Model\Attribute\Accessor;

/**
 * Trait Description
 *
 * @package Ds\Component\Model
 */
trait Description
{
    /**
     * Set description
     *
     * @param string $description
     * @return object
     */
    public function setDescription(?string $description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }
}
