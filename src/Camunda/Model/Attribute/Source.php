<?php

namespace Ds\Component\Camunda\Model\Attribute;

/**
 * Trait Source
 *
 * @package Ds\Component\Camunda
 */
trait Source
{
    /**
     * @var string
     */
    protected $source; # region accessors

    /**
     * Set source
     *
     * @param string $source
     * @return object
     */
    public function setSource($source)
    {
        $this->source = $source;

        return $this;
    }

    /**
     * Get source
     *
     * @return string
     */
    public function getSource()
    {
        return $this->source;
    }

    # endregion
}
