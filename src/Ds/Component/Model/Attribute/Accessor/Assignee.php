<?php

namespace Ds\Component\Model\Attribute\Accessor;

/**
 * Trait Assignee
 *
 * @package Ds\Component\Model
 */
trait Assignee
{
    /**
     * Set assignee
     *
     * @param string $assignee
     * @return object
     */
    public function setAssignee($assignee)
    {
        $this->assignee = $assignee;

        return $this;
    }

    /**
     * Get assignee
     *
     * @return string
     */
    public function getAssignee()
    {
        return $this->assignee;
    }
}
