<?php

namespace Ds\Component\Model\Attribute\Accessor;

use DateTime;

/**
 * Trait CreatedAt
 *
 * @package Ds\Component\Model
 */
trait CreatedAt
{
    /**
     * Set created at date
     *
     * @param \DateTime $createdAt
     * @return object
     */
    public function setCreatedAt(?DateTime $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get created at date
     *
     * @return \DateTime
     */
    public function getCreatedAt(): ?DateTime
    {
        return $this->createdAt;
    }
}
