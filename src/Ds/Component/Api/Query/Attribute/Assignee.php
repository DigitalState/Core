<?php

namespace Ds\Component\Api\Query\Attribute;

/**
 * Trait Assignee
 * 
 * @package Ds\Component\Api
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
     * @return \Ds\Component\Api\Query\Parameters
     */
    public function setAssignee($assignee)
    {
        $this->assignee = $assignee;
        $this->_assignee = true;

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

    /**
     * @var boolean
     */
    protected $_assignee;
}
