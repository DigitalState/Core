<?php

namespace Ds\Component\Model\Attribute\Accessor;

/**
 * Trait AssigneeUuid
 *
 * @package Ds\Component\Model
 */
trait AssigneeUuid
{
    /**
     * Set assignee uuid
     *
     * @param string $assigneeUuid
     * @return object
     */
    public function setAssigneeUuid($assigneeUuid)
    {
        $this->assigneeUuid = $assigneeUuid;

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
}
