<?php

namespace Ds\Component\Camunda\Query\Attribute;

/**
 * Trait Priority
 *
 * @package Ds\Component\Camunda
 */
trait Priority
{
    /**
     * @var string
     */
    private $priority; # region accessors

    /**
     * Set priority
     *
     * @param string $priority
     * @return object
     */
    public function setPriority(?string $priority)
    {
        $this->priority = $priority;
        $this->_priority = null !== $priority;

        return $this;
    }

    /**
     * Get priority
     *
     * @return string
     */
    public function getPriority(): ?string
    {
        return $this->priority;
    }

    # endregion

    /**
     * @var boolean
     */
    private $_priority;
}
