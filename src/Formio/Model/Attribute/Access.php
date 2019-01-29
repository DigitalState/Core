<?php

namespace Ds\Component\Formio\Model\Attribute;

/**
 * Trait Access
 *
 * @package Ds\Component\Formio
 */
trait Access
{
    /**
     * @var array
     */
    private $access; # region accessors

    /**
     * Set access
     *
     * @param array $access
     * @return object
     */
    public function setAccess(array $access)
    {
        $this->access = $access;

        return $this;
    }

    /**
     * Get access
     *
     * @return array
     */
    public function getAccess(): array
    {
        return $this->access;
    }

    # endregion
}
