<?php

namespace Ds\Component\Api\Bridge\Symfony\Bundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class ServicePass
 *
 * @package Ds\Component\Api
 */
class ServicePass implements CompilerPassInterface
{
    /**
     * Process
     *
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->has('ds_api.collection.service')) {
            return;
        }

        $definition = $container->findDefinition('ds_api.collection.service');
        $services = $container->findTaggedServiceIds('ds_api.service');

        foreach ($services as $id => $tags) {
            foreach ($tags as $tag) {
                if (array_key_exists('alias', $tag)) {
                    $definition->addMethodCall('set', [ $tag['alias'], new Reference($id) ]);
                } else {
                    $definition->addMethodCall('add', [ new Reference($id) ]);
                }
            }
        }
    }
}
