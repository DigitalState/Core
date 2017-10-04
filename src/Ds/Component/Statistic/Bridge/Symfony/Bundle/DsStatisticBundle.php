<?php

namespace Ds\Component\Statistic\Bridge\Symfony\Bundle;

use Ds\Component\Statistic\Bridge\Symfony\Bundle\DependencyInjection\Compiler;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class DsStatisticBundle
 *
 * @package Ds\Component\Statistic
 */
class DsStatisticBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new Compiler\StatPass);
    }
}
