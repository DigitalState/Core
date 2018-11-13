<?php

namespace Ds\Component\Camunda\Query\Attribute;

/**
 * Trait IncludeAssignedTasks
 *
 * @package Ds\Component\Camunda
 */
trait IncludeAssignedTasks
{
    /**
     * @var boolean
     */
    private $includeAssignedTasks; # region accessors

    /**
     * Set include assigned tasks
     *
     * @param boolean $includeAssignedTasks
     * @return object
     */
    public function setIncludeAssignedTasks(?bool $includeAssignedTasks)
    {
        $this->includeAssignedTasks = $includeAssignedTasks;
        $this->_includeAssignedTasks = null !== $includeAssignedTasks;

        return $this;
    }

    /**
     * Get includeAssignedTasks
     *
     * @return boolean
     */
    public function getIncludeAssignedTasks(): ?bool
    {
        return $this->includeAssignedTasks;
    }

    # endregion

    /**
     * @var boolean
     */
    private $_includeAssignedTasks;
}
