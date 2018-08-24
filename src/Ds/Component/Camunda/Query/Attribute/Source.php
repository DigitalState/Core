<?php

namespace Ds\Component\Camunda\Query\Attribute;

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
        $this->_source = null !== $source;

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

    /**
     * @var boolean
     */
    protected $_source;
}
