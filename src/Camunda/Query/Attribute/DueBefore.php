<?php

namespace Ds\Component\Camunda\Query\Attribute;

use DateTime;

/**
 * Trait DueBefore
 *
 * @package Ds\Component\Camunda
 */
trait DueBefore
{
    /**
     * @var \DateTime
     */
    private $dueBefore; # region accessors

    /**
     * Set due before
     *
     * @param \DateTime $dueBefore
     * @return object
     */
    public function setDueBefore(?DateTime $dueBefore)
    {
        $this->dueBefore = $dueBefore;
        $this->_dueBefore = null !== $dueBefore;

        return $this;
    }

    /**
     * Get due before
     *
     * @return \DateTime
     */
    public function getDueBefore(): ?DateTime
    {
        return $this->dueBefore;
    }

    # endregion

    /**
     * @var boolean
     */
    private $_dueBefore;
}
