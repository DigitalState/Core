<?php

namespace Ds\Component\Config\Bridge\Symfony\Bundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class ConfigPass
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
