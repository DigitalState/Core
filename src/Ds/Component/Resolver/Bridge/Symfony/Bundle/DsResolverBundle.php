<?php

namespace Ds\Component\Resolver\Bridge\Symfony\Bundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Ds\Component\Resolver\Bridge\Symfony\Bundle\DependencyInjection\Compiler;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class DsResolverBundle
 *
 * @package Ds\Component\Resolver
 */
class DsResolverBundle extends Bundle
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
