<?php

namespace Ds\Component\Camunda\Query\Attribute;

/**
 * Trait FirstResult
 *
 * @package Ds\Component\Camunda
 */
trait FirstResult
{
    /**
     * @var integer
     */
    protected $firstResult; # region accessors

    /**
     * Set first result
     *
     * @param integer $firstResult
     * @return object
     */
    public function setFirstResult($firstResult)
    {
        $this->firstResult = $firstResult;
        $this->_firstResult = null !== $firstResult;

        return $this;
    }

    /**
     * Get first result
     *
     * @return integer
     */
    public function getFirstResult()
    {
        return $this->firstResult;
    }

    # endregion

    /**
     * @var boolean
     */
    protected $_firstResult;
}
