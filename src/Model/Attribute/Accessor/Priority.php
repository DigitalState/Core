<?php

namespace Ds\Component\Model\Attribute\Accessor;

/**
 * Trait Priority
 *
 * @package Ds\Component\Model
 */
trait Priority
{
    /**
     * Set priority
     *
     * @param integer $priority
     * @return object
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;

        return $this;
    }

    /**
     * Get priority
     *
     * @return integer
     */
    public function getPriority()
    {
        return $this->priority;
    }
}
