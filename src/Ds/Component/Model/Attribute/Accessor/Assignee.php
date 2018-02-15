<?php

namespace Ds\Component\Model\Attribute\Accessor;

use DomainException;

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
     * @throws \DomainException
     */
    public function setAssignee($assignee = null)
    {
        if (null !== $assignee) {
            if (!preg_match('/^[a-z]+$/i', $assignee)) {
                throw new DomainException('Assignee is not valid.');
            }
        }

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
