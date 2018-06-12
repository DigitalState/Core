<?php

namespace Ds\Component\Config\Bridge\Symfony\Bundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class ParameterPass
 *
 * @package Ds\Component\Config
 */
class ParameterPass implements CompilerPassInterface
{
    /**
     * Process
     *
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->has('ds_config.collection.parameter')) {
            return;
        }

        $definition = $container->findDefinition('ds_config.collection.parameter');

        foreach ($container->getParameterBag()->all() as $key => $value) {
            if (strpos($key, 'ds_config.parameters.') === 0) {
                $definition->addMethodCall('set', [substr($key, 18), $value]);
            }
        }
    }
}
