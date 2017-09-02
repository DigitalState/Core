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
    protected $resource; # region accessors

    /**
     * Set resource
     *
     * @param string $resource
     * @return object
     */
    public function setResource($resource)
    {
        $this->resource = $resource;

        return $this;
    }

    /**
     * Get resource
     *
     * @return string
     */
    public function getResource()
    {
        return $this->resource;
    }

    # endregion
}
