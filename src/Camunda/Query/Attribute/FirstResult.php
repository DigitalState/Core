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
    private $firstResult; # region accessors

    /**
     * Set first result
     *
     * @param integer $firstResult
     * @return object
     */
    public function setFirstResult(?int $firstResult)
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
    public function getFirstResult(): ?int
    {
        return $this->firstResult;
    }

    # endregion

    /**
     * @var boolean
     */
    private $_firstResult;
}
