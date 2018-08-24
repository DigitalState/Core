<?php

namespace Ds\Component\Model\Attribute\Accessor;

/**
 * Trait Display
 */
trait Display
{
    /**
     * Set display
     *
     * @param string $display
     * @return object
     */
    public function setDisplay($display)
    {
        $this->display = $display;

        return $this;
    }

    /**
     * Get display
     *
     * @return string
     */
    public function getDisplay()
    {
        return $this->display;
    }
}
