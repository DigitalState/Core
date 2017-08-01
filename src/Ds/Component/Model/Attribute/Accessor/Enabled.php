<?php

namespace Ds\Component\Model\Attribute\Accessor;

use DateTime;

/**
 * Trait Enabled
 */
trait Enabled
{
    /**
     * Set enabled
     *
     * @param boolean $enabled
     * @return object
     */
    public function setEnabled($enabled)
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
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * Check if enabled or not
     *
     * @return boolean
     */
    public function isEnabled()
    {
        return $this->enabled;
    }
}
