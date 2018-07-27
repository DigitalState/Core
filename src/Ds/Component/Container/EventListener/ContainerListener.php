<?php

namespace Ds\Component\Container\EventListener;

use Ds\Component\Container\Attribute;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class ContainerListener
 *
 * @package Ds\Component\Container
 */
abstract class ContainerListener
{
    use Attribute\Container;

    /**
     * Constructor
     *
     * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }
}
