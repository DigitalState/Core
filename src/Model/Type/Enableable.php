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
     * @return \Ds\Component\Model\Type\Enableable
     */
    public function setEnabled(bool $enabled): Enableable;

    /**
     * Get enabled status
     *
     * @return boolean
     */
    public function getEnabled(): ?bool;

    /**
     * Check if enabled or not
     *
     * @return boolean
     */
    public function isEnabled(): ?bool;
}
