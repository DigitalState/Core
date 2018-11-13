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
    private $assigneeUuid; # region accessors

    /**
     * Set assignee uuid
     *
     * @param string $assigneeUuid
     * @return object
     */
    public function setAssigneeUuid(?string $assigneeUuid)
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
    public function getAssigneeUuid(): ?string
    {
        return $this->assigneeUuid;
    }

    # endregion

    /**
     * @var boolean
     */
    private $_assigneeUuid;
}
