<?php

namespace Ds\Component\Camunda\Model\Attribute;

/**
 * Trait Value
 *
 * @package Ds\Component\Camunda
 */
trait Value
{
    /**
     * @var string
     */
    protected $value; # region accessors

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

    # endregion
}
