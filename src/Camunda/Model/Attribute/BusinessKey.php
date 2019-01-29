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
    private $businessKey; # region accessors

    /**
     * Set business key
     *
     * @param string $businessKey
     * @return object
     */
    public function setBusinessKey(?string $businessKey)
    {
        $this->businessKey = $businessKey;

        return $this;
    }

    /**
     * Get business key
     *
     * @return string
     */
    public function getBusinessKey(): ?string
    {
        return $this->businessKey;
    }

    # endregion
}
