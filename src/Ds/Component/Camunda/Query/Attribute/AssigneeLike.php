<?php

namespace Ds\Component\Camunda\Query\Attribute;

/**
 * Trait AssigneeLike
 *
 * @package Ds\Component\Camunda
 */
trait AssigneeLike
{
    /**
     * @var string
     */
    protected $assigneeLike; # region accessors

    /**
     * Set assignee like
     *
     * @param string $assigneeLike
     * @return object
     */
    public function setAssigneeLike($assigneeLike)
    {
        $this->assigneeLike = $assigneeLike;
        $this->_assigneeLike = null !== $assigneeLike;

        return $this;
    }

    /**
     * Get assignee like
     *
     * @return string
     */
    public function getAssigneeLike()
    {
        return $this->assigneeLike;
    }

    # endregion

    /**
     * @var boolean
     */
    protected $_assigneeLike;
}
