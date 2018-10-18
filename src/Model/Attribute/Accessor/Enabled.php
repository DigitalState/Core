<?php

namespace Ds\Component\Model\Attribute\Accessor;

use DateTime;

/**
 * Trait Enabled
 *
 * @package Ds\Component\Model
 */
trait Enabled
{
    /**
     * Set enabled
     *
     * @param boolean $enabled
     * @return object
     */
    public function setEnabled(?bool $enabled)
    {
        $this->enabled = $enabled;

        if (property_exists($this, 'enabledAt')) {
            $this->enabledAt = $enabled ? new DateTime : null;
        }

        return $this;
    }

    /**
     * Get enabled
     *
     * @return boolean
     */
    public function getEnabled(): ?bool
    {
        return $this->enabled;
    }

    /**
     * Check if enabled or not
     *
     * @return boolean
     */
    public function isEnabled(): ?bool
    {
        return $this->enabled;
    }
}
