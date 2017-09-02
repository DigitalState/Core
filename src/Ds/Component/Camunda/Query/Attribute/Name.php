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
        $this->_name = true;

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

    /**
     * @var boolean
     */
    protected $_name;
}
