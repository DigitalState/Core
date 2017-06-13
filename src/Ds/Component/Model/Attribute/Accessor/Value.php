<?php

namespace Ds\Component\Model\Attribute\Accessor;

/**
 * Trait Value
 */
trait Value
{
    /**
     * Set value
     *
     * @param mixed $value
     * @return object
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }
}
