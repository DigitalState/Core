<?php

namespace Ds\Component\Model\Attribute\Accessor;

/**
 * Trait Attribute
 *
 * @package Ds\Component\Model
 */
trait Attribute
{
    /**
     * Set attribute
     *
     * @param string $attribute
     * @return object
     */
    public function setAttribute($attribute)
    {
        $this->attribute = $attribute;

        return $this;
    }

    /**
     * Get attribute
     *
     * @return string
     */
    public function getAttribute()
    {
        return $this->attribute;
    }
}
