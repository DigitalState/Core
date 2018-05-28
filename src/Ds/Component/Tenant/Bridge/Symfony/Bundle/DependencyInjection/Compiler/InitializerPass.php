<?php

namespace Ds\Component\Tenant\Bridge\Symfony\Bundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class InitializerPass
 */
class InitializerPass implements CompilerPassInterface
{
    /**
     * Process
     *
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->has('ds_tenant.collection.initializer')) {
            return;
        }

        $definition = $container->findDefinition('ds_tenant.collection.initializer');
        $services = $container->findTaggedServiceIds('ds_tenant.initializer');

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
