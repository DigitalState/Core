<?php

namespace Ds\Component\Container\Attribute;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Trait Container
 */
trait Container
{
    /**
     * @var \Symfony\Component\DependencyInjection\ContainerInterface
     */
    protected $container; # region accessors

    /**
     * Set container
     * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    # endregion
}