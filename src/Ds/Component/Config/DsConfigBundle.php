<?php

namespace Ds\Component\Config;

use Ds\Component\Config\DependencyInjection\Compiler;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class DsConfigBundle
 *
 * @package Ds\Component\Config
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
        $container->addCompilerPass(new Compiler\ParameterPass);
    }
}
