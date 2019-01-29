<?php

namespace Ds\Component\Camunda\Model\Attribute;

/**
 * Trait Suspended
 *
 * @package Ds\Component\Camunda
 */
trait Suspended
{
    /**
     * @var boolean
     */
    private $suspended; # region accessors

    /**
     * Set suspended
     *
     * @param boolean $suspended
     * @return object
     */
    public function setSuspended(?bool $suspended)
    {
        $this->suspended = $suspended;

        return $this;
    }

    /**
     * Get suspended
     *
     * @return boolean
     */
    public function getSuspended(): ?bool
    {
        return $this->suspended;
    }

    # endregion
}
