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
     * @param object $resource
     * @return object
     */
    public function setResource(?object $resource)
    {
        $this->resource = $resource;

        return $this;
    }

    /**
     * Get resource
     *
     * @return mixed
     */
    public function getResource(): ?object
    {
        return $this->resource;
    }
}
