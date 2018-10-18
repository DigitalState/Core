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
     * @return \Ds\Component\Model\Type\Assignable
     */
    public function setAssignee(string $assignee): Assignable;

    /**
     * Get assignee
     *
     * @return string
     */
    public function getAssignee(): ?string;

    /**
     * Set assignee uuid
     *
     * @param string $assigneeUuid
     * @return \Ds\Component\Model\Type\Assignable
     */
    public function setAssigneeUuid(string $assigneeUuid): Assignable;

    /**
     * Get assignee uuid
     *
     * @return string
     */
    public function getAssigneeUuid(): ?string;
}
