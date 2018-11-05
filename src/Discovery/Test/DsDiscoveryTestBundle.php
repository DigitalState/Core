<?php

namespace Ds\Component\Discovery\Test;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Ds\Component\Discovery\Test\DependencyInjection\Compiler;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class DsDiscoveryTestBundle
 *
 * @package Ds\Component\Discovery
 */
final class DsDiscoveryTestBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new Compiler\ParameterPass);
    }
}
