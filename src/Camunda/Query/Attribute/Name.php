<?php

namespace Ds\Component\Camunda\Query\Attribute;

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
    private $name; # region accessors

    /**
     * Set name
     *
     * @param string $name
     * @return object
     */
    public function setName(?string $name)
    {
        $this->name = $name;
        $this->_name = null !== $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    # endregion

    /**
     * @var boolean
     */
    private $_name;
}
