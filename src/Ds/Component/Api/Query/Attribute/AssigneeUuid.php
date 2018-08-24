<?php

namespace Ds\Component\Api\Query\Attribute;

/**
 * Trait AssigneeUuid
 * 
 * @package Ds\Component\Api
 */
trait AssigneeUuid
{
    /**
     * @var string
     */
    protected $assigneeUuid; # region accessors

    /**
     * Set assignee uuid
     *
     * @param string $assigneeUuid
     * @return \Ds\Component\Api\Query\Parameters
     */
    public function setAssigneeUuid($assigneeUuid)
    {
        $this->assigneeUuid = $assigneeUuid;
        $this->_assigneeUuid = true;

        return $this;
    }

    /**
     * Get assignee uuid
     *
     * @return string
     */
    public function getAssigneeUuid()
    {
        return $this->assigneeUuid;
    }

    # endregion

    /**
     * @var boolean
     */
    protected $_assigneeUuid;
}
