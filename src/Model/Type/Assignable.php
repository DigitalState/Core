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
     */
    public function setAssignee(?string $assignee);

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
     */
    public function setAssigneeUuid(?string $assigneeUuid);

    /**
     * Get assignee uuid
     *
     * @return string
     */
    public function getAssigneeUuid(): ?string;
}
