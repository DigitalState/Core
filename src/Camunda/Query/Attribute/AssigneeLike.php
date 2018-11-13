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
    private $assigneeLike; # region accessors

    /**
     * Set assignee like
     *
     * @param string $assigneeLike
     * @return object
     */
    public function setAssigneeLike(?string $assigneeLike)
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
    public function getAssigneeLike(): ?string
    {
        return $this->assigneeLike;
    }

    # endregion

    /**
     * @var boolean
     */
    private $_assigneeLike;
}
