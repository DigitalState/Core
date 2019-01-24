<?php

namespace Ds\Component\Translation\Model\Attribute\Accessor;

/**
 * Trait Description
 *
 * @package Ds\Component\Translation
 */
trait Description
{
    /**
     * Set description
     *
     * @param array $description
     * @return object
     */
    public function setDescription(array $description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return array
     */
    public function getDescription()
    {
        return $this->description;
    }
}
