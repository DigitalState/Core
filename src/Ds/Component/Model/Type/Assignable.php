<?php

namespace Ds\Component\Model\Type;

/**
 * Interface Assignable
 *
 * @package Ds\Component\Model
 */
interface Assignable
{
    /**
     * Set assignee
     *
     * @param string $assignee
     * @return object
     */
    public function setAssignee($assignee);

    /**
     * Get assignee
     *
     * @return string
     */
    public function getAssignee();

    /**
     * Set assignee uuid
     *
     * @param string $assigneeUuid
     * @return object
     */
    public function setAssigneeUuid($assigneeUuid);

    /**
     * Get assignee uuid
     *
     * @return string
     */
    public function getAssigneeUuid();
}
