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
    private $version; # region accessors

    /**
     * Set version
     *
     * @param integer $version
     * @return object
     */
    public function setVersion(?int $version)
    {
        $this->version = $version;

        return $this;
    }

    /**
     * Get version
     *
     * @return integer
     */
    public function getVersion(): ?int
    {
        return $this->version;
    }

    # endregion
}
