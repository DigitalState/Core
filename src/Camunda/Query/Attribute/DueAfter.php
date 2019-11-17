<?php

namespace Ds\Component\Camunda\Query\Attribute;

use DateTime;

/**
 * Trait DueAfter
 *
 * @package Ds\Component\Camunda
 */
trait DueAfter
{
    /**
     * @var \DateTime
     */
    private $dueAfter; # region accessors

    /**
     * Set due after
     *
     * @param \DateTime $dueAfter
     * @return object
     */
    public function setDueAfter(?DateTime $dueAfter)
    {
        $this->dueAfter = $dueAfter;
        $this->_dueAfter = null !== $dueAfter;

        return $this;
    }

    /**
     * Get due after
     *
     * @return \DateTime
     */
    public function getDueAfter(): ?DateTime
    {
        return $this->dueAfter;
    }

    # endregion

    /**
     * @var boolean
     */
    private $_dueAfter;
}
