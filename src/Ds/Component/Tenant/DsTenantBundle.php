<?php

namespace Ds\Component\Tenant;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Ds\Component\Tenant\DependencyInjection\Compiler;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class DsTenantBundle
 *
 * @package Ds\Component\Tenant
 */
class DsTenantBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new Compiler\LoaderPass);
        $container->addCompilerPass(new Compiler\UnloaderPass);
    }
}
