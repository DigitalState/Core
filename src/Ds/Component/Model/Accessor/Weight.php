<?php

namespace Ds\Component\Model\Accessor;

/**
 * Trait Weight
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
