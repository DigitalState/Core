<?php

namespace Ds\Component\Model\Type;

/**
 * Interface Enableable
 *
 * @package Ds\Component\Model
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

    /**
     * Check if enabled or not
     *
     * @return boolean
     */
    public function isEnabled();
}
