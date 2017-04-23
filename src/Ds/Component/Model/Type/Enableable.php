<?php

namespace Ds\Component\Model\Type;

/**
 * Interface Enableable
 */
interface Enableable
{
    /**
     * Set enabled status
     *
     * @param boolean $enabled
     * @return object
     */
    public function setEnabled($enabled);

    /**
     * Get enabled status
     *
     * @return boolean
     */
    public function getEnabled();
}
