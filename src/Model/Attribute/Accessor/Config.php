<?php

namespace Ds\Component\Model\Attribute\Accessor;

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
     * @return array
     */
    public function getConfig(): ?array
    {
        return $this->config;
    }
}
