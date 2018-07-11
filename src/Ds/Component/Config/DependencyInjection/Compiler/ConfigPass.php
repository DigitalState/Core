<?php

namespace Ds\Component\Config\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class ConfigPass
 *
 * @package Ds\Component\Config
 */
class ConfigPass implements CompilerPassInterface
{
    /**
     * Process
     *
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->has('ds_config.collection.config')) {
            return;
        }

        $definition = $container->findDefinition('ds_config.collection.config');

        foreach ($container->getParameterBag()->all() as $key => $value) {
            if (strpos($key, 'ds_config.configs.') === 0) {
                $definition->addMethodCall('set', [substr($key, 18), $value]);
            }
        }
    }
}
