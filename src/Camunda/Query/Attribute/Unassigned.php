<?php

namespace Ds\Component\Camunda\Query\Attribute;

/**
 * Trait Unassigned
 *
 * @package Ds\Component\Camunda
 */
trait Unassigned
{
    /**
     * @var boolean
     */
    private $unassigned; # region accessors

    /**
     * Set unassigned
     *
     * @param boolean $unassigned
     * @return object
     */
    public function setUnassigned(?bool $unassigned)
    {
        $this->unassigned = $unassigned;
        $this->_unassigned = null !== $unassigned;

        return $this;
    }

    /**
     * Get unassigned
     *
     * @return boolean
     */
    public function getUnassigned(): ?bool
    {
        return $this->unassigned;
    }

    # endregion

    /**
     * @var boolean
     */
    private $_unassigned;
}
