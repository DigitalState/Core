<?php

namespace Ds\Component\Security\Model\Attribute\Accessor;

/**
 * Trait Value
 */
trait Value
{
    /**
     * Set value
     *
     * @param string $value
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
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }
}
