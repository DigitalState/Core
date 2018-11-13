<?php

namespace Ds\Component\Camunda\Model\Attribute;

/**
 * Trait Priority
 *
 * @package Ds\Component\Camunda
 */
trait Priority
{
    /**
     * @var integer
     */
    private $priority; # region accessors

    /**
     * Set priority
     *
     * @param integer $priority
     * @return object
     */
    public function setPriority(?int $priority)
    {
        $this->priority = $priority;

        return $this;
    }

    /**
     * Get priority
     *
     * @return integer
     */
    public function getPriority(): ?int
    {
        return $this->priority;
    }

    # endregion
}
