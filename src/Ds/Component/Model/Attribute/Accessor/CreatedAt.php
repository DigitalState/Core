<?php

namespace Ds\Component\Model\Attribute\Accessor;

use DateTime;

/**
 * Trait CreatedAt
 */
trait CreatedAt
{
    /**
     * Set created at date
     *
     * @param \DateTime $createdAt
     * @return object
     */
    public function setCreatedAt(DateTime $createdAt = null)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get created at date
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
}
