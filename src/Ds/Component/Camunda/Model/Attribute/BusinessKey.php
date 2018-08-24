<?php

namespace Ds\Component\Camunda\Model\Attribute;

/**
 * Trait BusinessKey
 *
 * @package Ds\Component\Camunda
 */
trait BusinessKey
{
    /**
     * @var string
     */
    protected $businessKey; # region accessors

    /**
     * Set business key
     *
     * @param string $businessKey
     * @return object
     */
    public function setBusinessKey($businessKey)
    {
        $this->businessKey = $businessKey;

        return $this;
    }

    /**
     * Get business key
     *
     * @return string
     */
    public function getBusinessKey()
    {
        return $this->businessKey;
    }

    # endregion
}
