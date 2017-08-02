<?php

namespace Ds\Component\Model\Attribute\Accessor;

/**
 * Trait Weight
 *
 * @package Ds\Component\Model
 */
trait Weight
{
    /**
     * Set weight
     *
     * @param integer $weight
     * @return object
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * Get weight
     *
     * @return integer
     */
    public function getWeight()
    {
        return $this->weight;
    }
}
