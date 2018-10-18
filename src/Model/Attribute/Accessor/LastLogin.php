<?php

namespace Ds\Component\Model\Attribute\Accessor;

use DateTime;

/**
 * Trait LastLogin
 *
 * @package Ds\Component\Model
 */
trait LastLogin
{
    /**
     * Set created at date
     *
     * @param \DateTime $lastLogin
     * @return object
     */
    public function setLastLogin(?DateTime $lastLogin)
    {
        $this->lastLogin = $lastLogin;

        return $this;
    }

    /**
     * Get created at date
     *
     * @return \DateTime
     */
    public function getLastLogin(): ?DateTime
    {
        return $this->lastLogin;
    }
}
