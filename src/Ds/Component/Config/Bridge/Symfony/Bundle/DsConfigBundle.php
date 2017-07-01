<?php

namespace Ds\Component\Config\Bridge\Symfony\Bundle;

use Ds\Component\Config\Bridge\Symfony\Bundle\DependencyInjection\Compiler;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

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
