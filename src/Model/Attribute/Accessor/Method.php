<?php

namespace Ds\Component\Model\Attribute\Accessor;

/**
 * Trait Method
 *
 * @package Ds\Component\Model
 */
trait Method
{
    /**
     * Set method
     *
     * @param string $method
     * @return object
     */
    public function setMethod(?string $method)
    {
        $this->method = $method;

        return $this;
    }

    /**
     * Get method
     *
     * @return string
     */
    public function getMethod(): ?string
    {
        return $this->method;
    }
}
