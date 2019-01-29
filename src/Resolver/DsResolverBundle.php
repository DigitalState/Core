<?php

namespace Ds\Component\Resolver;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Ds\Component\Resolver\DependencyInjection\Compiler;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class DsResolverBundle
 *
 * @package Ds\Component\Resolver
 */
final class DsResolverBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new Compiler\ResolverPass);
    }
}
