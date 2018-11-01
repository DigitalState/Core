<?php

namespace Ds\Component\Model\Attribute\Accessor;

use OutOfRangeException;

/**
 * Trait Config
 *
 * @package Ds\Component\Model
 */
trait Config
{
    /**
     * Set config
     *
     * @param array $config
     * @return object
     */
    public function setConfig(?array $config)
    {
        $this->config = $config;

        return $this;
    }

    /**
     * Get config
     *
     * @param string $property
     * @return array
     * @throws \OutOfRangeException
     */
    public function getConfig(?string $property)
    {
        if (null === $property) {
            return $this->config;
        }

        if (!array_key_exists($property, $this->config)) {
            throw new OutOfRangeException('Array property does not exist.');
        }

        return $this->config[$property];
    }
}
