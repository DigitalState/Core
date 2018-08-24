<?php

namespace Ds\Component\Camunda\Model\Attribute;

/**
 * Trait Version
 *
 * @package Ds\Component\Camunda
 */
trait Version
{
    /**
     * @var integer
     */
    protected $version; # region accessors

    /**
     * Set version
     *
     * @param integer $version
     * @return object
     */
    public function setVersion($version)
    {
        $this->version = $version;

        return $this;
    }

    /**
     * Get version
     *
     * @return integer
     */
    public function getVersion()
    {
        return $this->version;
    }

    # endregion
}
