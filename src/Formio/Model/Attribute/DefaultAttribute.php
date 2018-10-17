<?php

namespace Ds\Component\Formio\Model\Attribute;

/**
 * Trait Default
 *
 * @package Ds\Component\Formio
 */
trait DefaultAttribute
{
    /**
     * @var boolean
     */
    protected $default; # region accessors

    /**
     * Set default
     *
     * @param boolean $default
     * @return object
     */
    public function setDefault($default)
    {
        $this->default = $default;

        return $this;
    }

    /**
     * Get default
     *
     * @return boolean
     */
    public function getDefault()
    {
        return $this->default;
    }

    # endregion
}
