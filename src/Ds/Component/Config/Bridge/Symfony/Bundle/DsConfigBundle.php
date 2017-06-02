<?php

namespace Ds\Component\Config\Bridge\Symfony\Bundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Ds\Component\Config\Bridge\Symfony\Bundle\DependencyInjection\Compiler;

/**
 * Class DsConfigBundle
 */
class DsConfigBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new Compiler\ConfigPass);
    }
}
