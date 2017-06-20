<?php

namespace Ds\Component\Security\Model\Attribute\Accessor;

/**
 * Trait Attributes
 */
trait Attributes
{
    /**
     * Set attributes
     *
     * @param array $attributes
     * @return object
     */
    public function setAttributes(array $attributes)
    {
        $this->attributes = $attributes;

        return $this;
    }

    /**
     * Get attributes
     *
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }
}
