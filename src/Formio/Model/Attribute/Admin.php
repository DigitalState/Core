<?php

namespace Ds\Component\Formio\Model\Attribute;

/**
 * Trait Admin
 *
 * @package Ds\Component\Formio
 */
trait Admin
{
    /**
     * @var boolean
     */
    private $admin; # region accessors

    /**
     * Set admin
     *
     * @param boolean $admin
     * @return object
     */
    public function setAdmin(?bool $admin)
    {
        $this->admin = $admin;

        return $this;
    }

    /**
     * Get admin
     *
     * @return boolean
     */
    public function getAdmin(): ?bool
    {
        return $this->admin;
    }

    # endregion
}
