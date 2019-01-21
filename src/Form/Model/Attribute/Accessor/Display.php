<?php

namespace Ds\Component\Form\Model\Attribute\Accessor;

/**
 * Trait Display
 *
 * @package Ds\Component\Form
 */
trait Display
{
    /**
     * Set display
     *
     * @param string $display
     * @return object
     */
    public function setDisplay(?string $display)
    {
        $this->display = $display;

        return $this;
    }

    /**
     * Get display
     *
     * @return string
     */
    public function getDisplay(): ?string
    {
        return $this->display;
    }
}
