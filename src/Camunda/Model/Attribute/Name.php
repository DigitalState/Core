<?php

namespace Ds\Component\Camunda\Model\Attribute;

/**
 * Trait Name
 *
 * @package Ds\Component\Camunda
 */
trait Name
{
    /**
     * @var string
     */
    protected $name; # region accessors

    /**
     * Set name
     *
     * @param string $name
     * @return object
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    # endregion
}
