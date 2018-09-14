<?php

namespace Ds\Component\Discovery\Test\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class ParameterPass
 */
class ParameterPass implements CompilerPassInterface
{
    /**
     * Process
     *
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        if ('vendor/bin/behat' === $_SERVER['PHP_SELF']) {
            $container->setParameter('discovery_host', 'localhost:8500');
        }
    }
}
