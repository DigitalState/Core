<?php

namespace Ds\Component\Translation\Model\Attribute\Accessor;

/**
 * Trait Value
 *
 * @package Ds\Component\Translation
 */
trait Value
{
    /**
     * Set value
     *
     * @param array $value
     * @return object
     */
    public function setValue(array $value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return array
     */
    public function getValue()
    {
        return $this->value;
    }
}
