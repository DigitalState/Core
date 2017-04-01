<?php

namespace Ds\Component\Entity\Entity\Accessor;

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
}
