<?php

namespace Ds\Component\Camunda\Query\Attribute;

/**
 * Trait WithVariablesInReturn
 *
 * @package Ds\Component\Camunda
 */
trait WithVariablesInReturn
{
    /**
     * @var string
     */
    protected $withVariablesInReturn; # region accessors

    /**
     * Set with variables in return
     *
     * @param boolean $withVariablesInReturn
     * @return object
     */
    public function setWithVariablesInReturn($withVariablesInReturn)
    {
        $this->withVariablesInReturn = $withVariablesInReturn;
        $this->_withVariablesInReturn = null !== $withVariablesInReturn;

        return $this;
    }

    /**
     * Get with variables in return
     *
     * @return boolean
     */
    public function getWithVariablesInReturn()
    {
        return $this->withVariablesInReturn;
    }

    # endregion

    /**
     * @var boolean
     */
    protected $_withVariablesInReturn;
}
