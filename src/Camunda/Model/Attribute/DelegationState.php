<?php

namespace Ds\Component\Camunda\Model\Attribute;

/**
 * Trait DelegationState
 *
 * @package Ds\Component\Camunda
 */
trait DelegationState
{
    /**
     * @var string
     */
    private $delegationState; # region accessors

    /**
     * Set delegation state
     *
     * @param string $delegationState
     * @return object
     */
    public function setDelegationState(?string $delegationState)
    {
        $this->delegationState = $delegationState;

        return $this;
    }

    /**
     * Get delegation state
     *
     * @return string
     */
    public function getDelegationState(): ?string
    {
        return $this->delegationState;
    }

    # endregion
}
