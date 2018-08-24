<?php

namespace Ds\Component\Container\Attribute;

/**
 * Trait Container
 *
 * @package Ds\Component\Container
 */
trait Container
{
    use Accessor\Container;

    /**
     * @var \Symfony\Component\DependencyInjection\ContainerInterface
     */
    protected $container;
}
