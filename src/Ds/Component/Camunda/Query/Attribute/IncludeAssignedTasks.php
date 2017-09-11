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
    protected $includeAssignedTasks; # region accessors

    /**
     * Set include assigned tasks
     *
     * @param boolean $includeAssignedTasks
     * @return object
     */
    public function setIncludeAssignedTasks($includeAssignedTasks)
    {
        $this->includeAssignedTasks = $includeAssignedTasks;
        $this->_includeAssignedTasks = true;

        return $this;
    }

    /**
     * Get includeAssignedTasks
     *
     * @return boolean
     */
    public function getIncludeAssignedTasks()
    {
        return $this->includeAssignedTasks;
    }

    # endregion

    /**
     * @var boolean
     */
    protected $_includeAssignedTasks;
}
