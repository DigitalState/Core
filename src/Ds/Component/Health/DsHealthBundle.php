<?php

namespace Ds\Component\Health;

use Ds\Component\Health\DependencyInjection\Compiler;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class DsHealthBundle
 *
 * @package Ds\Component\Health
 */
class DsHealthBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new Compiler\CheckPass);
    }
}
