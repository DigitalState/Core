<?php

namespace Ds\Component\Model\Attribute\Accessor;

use DateTime;

/**
 * Trait FollowUpAt
 *
 * @package Ds\Component\Model
 */
trait FollowUpAt
{
    /**
     * Set follow up at date
     *
     * @param \DateTime $followUpAt
     * @return object
     */
    public function setFollowUpAt(DateTime $followUpAt = null)
    {
        $this->followUpAt = $followUpAt;

        return $this;
    }

    /**
     * Get follow up at date
     *
     * @return \DateTime
     */
    public function getFollowUpAt()
    {
        return $this->followUpAt;
    }
}
