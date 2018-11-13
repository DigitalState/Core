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
    private $source; # region accessors

    /**
     * Set source
     *
     * @param string $source
     * @return object
     */
    public function setSource(?string $source)
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
    public function getSource(): ?string
    {
        return $this->source;
    }

    # endregion

    /**
     * @var boolean
     */
    private $_source;
}
