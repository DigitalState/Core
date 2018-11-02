<?php

namespace Ds\Component\Health\Model\Attribute\Accessor;

/**
 * Trait Healthy
 *
 * @package Ds\Component\Health
 */
trait Healthy
{
    /**
     * Set healthy
     *
     * @param boolean $healthy
     * @return object
     */
    public function setHealthy($healthy)
    {
        $this->healthy = $healthy;

        return $this;
    }

    /**
     * Get healthy
     *
     * @return boolean
     */
    public function getHealthy()
    {
        return $this->healthy;
    }
}
