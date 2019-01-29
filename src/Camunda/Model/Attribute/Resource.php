<?php

namespace Ds\Component\Camunda\Model\Attribute;

/**
 * Trait Resource
 *
 * @package Ds\Component\Camunda
 */
trait Resource
{
    /**
     * @var string
     */
    private $resource; # region accessors

    /**
     * Set resource
     *
     * @param string $resource
     * @return object
     */
    public function setResource(?string $resource)
    {
        $this->resource = $resource;

        return $this;
    }

    /**
     * Get resource
     *
     * @return string
     */
    public function getResource(): ?string
    {
        return $this->resource;
    }

    # endregion
}
