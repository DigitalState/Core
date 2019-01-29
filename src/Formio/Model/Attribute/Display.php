<?php

namespace Ds\Component\Formio\Model\Attribute;

/**
 * Trait Display
 *
 * @package Ds\Component\Formio
 */
trait Display
{
    /**
     * @var string
     */
    private $display; # region accessors

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

    # endregion
}
