<?php

namespace Ds\Component\Model\Attribute\Accessor;

use InvalidArgumentException;

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
     * @throws \InvalidArgumentException
     */
    public function setAssigneeUuid(?string $assigneeUuid)
    {
        if (null !== $assigneeUuid) {
            if (!preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i', $assigneeUuid)) {
                throw new InvalidArgumentException('Assignee uuid is not valid.');
            }
        }

        $this->assigneeUuid = $assigneeUuid;

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
}
