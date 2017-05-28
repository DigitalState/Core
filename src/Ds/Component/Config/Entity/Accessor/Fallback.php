<?php

namespace Ds\Component\Config\Accessor;

/**
 * Trait Fallback
 */
trait Fallback
{
    /**
     * Set fallback
     *
     * @param boolean $fallback
     * @return object
     */
    public function setFallback($fallback)
    {
        $this->fallback = $fallback;

        return $this;
    }

    /**
     * Get fallback
     *
     * @return boolean
     */
    public function getFallback()
    {
        return $this->fallback;
    }
}
