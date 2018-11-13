<?php

namespace Ds\Component\Formio\Model\Attribute;

/**
 * Trait Components
 *
 * @package Ds\Component\Formio
 */
trait Components
{
    /**
     * @var array
     */
    private $components; # region accessors

    /**
     * Set components
     *
     * @param array $components
     * @return object
     */
    public function setComponents(array $components)
    {
        $this->components = $components;

        return $this;
    }

    /**
     * Get components
     *
     * @return array
     */
    public function getComponents(): array
    {
        return $this->components;
    }

    # endregion
}
