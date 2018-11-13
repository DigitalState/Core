<?php

namespace Ds\Component\Camunda\Query\Attribute;

/**
 * Trait Cascade
 *
 * @package Ds\Component\Camunda
 */
trait Cascade
{
    /**
     * @var boolean
     */
    private $cascade; # region accessors

    /**
     * Set cascade
     *
     * @param boolean $cascade
     * @return object
     */
    public function setCascade(?bool $cascade)
    {
        $this->cascade = $cascade;
        $this->_cascade = null !== $cascade;

        return $this;
    }

    /**
     * Get cascade
     *
     * @return boolean
     */
    public function getCascade(): ?bool
    {
        return $this->cascade;
    }

    # endregion

    /**
     * @var boolean
     */
    private $_cascade;
}
