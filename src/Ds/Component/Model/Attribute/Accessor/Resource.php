<?php

namespace Ds\Component\Model\Attribute\Accessor;

/**
 * Trait Resource
 *
 * @package Ds\Component\Model
 */
trait Resource
{
    /**
     * Set resource
     *
     * @param mixed $resource
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
     * @return mixed
     */
    public function getResource()
    {
        return $this->resource;
    }
}
