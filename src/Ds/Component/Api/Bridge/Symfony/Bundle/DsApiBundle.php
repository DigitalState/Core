<?php

namespace Ds\Component\Api\Bridge\Symfony\Bundle;

use Ds\Component\Api\Bridge\Symfony\Bundle\DependencyInjection\Compiler;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class DsApiBundle
 *
 * @package Ds\Component\Api
 */
class DsApiBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new Compiler\ServicePass());
    }
}
