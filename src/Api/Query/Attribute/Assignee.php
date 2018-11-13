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
    private $assignee; # region accessors

    /**
     * Set assignee
     *
     * @param string $assignee
     * @return object
     */
    public function setAssignee(?string $assignee)
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
    public function getAssignee(): ?string
    {
        return $this->assignee;
    }

    # endregion

    /**
     * @var boolean
     */
    private $_assignee;
}
