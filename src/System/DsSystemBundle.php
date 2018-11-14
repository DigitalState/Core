<?php

namespace Ds\Component\System;

use Ds\Component\System\DependencyInjection\Compiler;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class DsSystemBundle
 *
 * @package Ds\Component\System
 */
final class DsSystemBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new Compiler\ServicePass);
    }
}
