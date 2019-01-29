<?php

namespace Ds\Component\Camunda\Model\Attribute;

use DateTime;

/**
 * Trait FollowUp
 *
 * @package Ds\Component\Camunda
 */
trait FollowUp
{
    /**
     * @var \DateTime
     */
    private $followUp; # region accessors

    /**
     * Set follow up
     *
     * @param \DateTime $followUp
     * @return object
     */
    public function setFollowUp(?DateTime $followUp)
    {
        $this->followUp = $followUp;

        return $this;
    }

    /**
     * Get follow up
     *
     * @return \DateTime
     */
    public function getFollowUp(): ?DateTime
    {
        return $this->followUp;
    }

    # endregion
}
