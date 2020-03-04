<?php

namespace Ds\Component\Discovery;

use Ds\Component\Discovery\DependencyInjection\Compiler;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class DsDiscoveryBundle
 *
 * @package Ds\Component\Discovery
 */
final class DsDiscoveryBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new Compiler\AdapterPass);
    }
}
