<?php

namespace Ds\Component\Container\Attribute\Accessor;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Trait Container
 *
 * @package Ds\Component\Container
 */
trait Container
{
    /**
     * Set container
     *
     * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
     * @return object
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;

        return $this;
    }

    /**
     * Get container
     *
     * @return \Symfony\Component\DependencyInjection\ContainerInterface
     */
    public function getContainer()
    {
        return $this->container;
    }
}
