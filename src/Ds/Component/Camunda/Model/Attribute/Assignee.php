<?php

namespace Ds\Component\Camunda\Model\Attribute;

/**
 * Trait Assignee
 *
 * @package Ds\Component\Camunda
 */
trait Assignee
{
    /**
     * @var string
     */
    protected $assignee; # region accessors

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

    # endregion
}
