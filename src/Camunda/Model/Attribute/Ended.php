<?php

namespace Ds\Component\Camunda\Model\Attribute;

/**
 * Trait Ended
 *
 * @package Ds\Component\Camunda
 */
trait Ended
{
    /**
     * @var boolean
     */
    private $ended; # region accessors

    /**
     * Set ended
     *
     * @param boolean $ended
     * @return object
     */
    public function setEnded(?bool $ended)
    {
        $this->ended = $ended;

        return $this;
    }

    /**
     * Get ended
     *
     * @return boolean
     */
    public function getEnded(): ?bool
    {
        return $this->ended;
    }

    # endregion
}
