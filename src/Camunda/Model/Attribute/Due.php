<?php

namespace Ds\Component\Camunda\Model\Attribute;

use DateTime;

/**
 * Trait Due
 *
 * @package Ds\Component\Camunda
 */
trait Due
{
    /**
     * @var \DateTime
     */
    private $due; # region accessors

    /**
     * Set due
     *
     * @param \DateTime $due
     * @return object
     */
    public function setDue(?DateTime $due)
    {
        $this->due = $due;

        return $this;
    }

    /**
     * Get due
     *
     * @return \DateTime
     */
    public function getDue(): ?DateTime
    {
        return $this->due;
    }

    # endregion
}
