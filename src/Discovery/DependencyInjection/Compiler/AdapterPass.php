<?php

namespace Ds\Component\Discovery\DependencyInjection\Compiler;

use Ds\Component\Discovery\Collection\AdapterCollection;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class AdapterPass
 *
 * @package Ds\Component\Discovery
 */
final class AdapterPass implements CompilerPassInterface
{
    /**
     * Process
     *
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        $definition = $container->findDefinition(AdapterCollection::class);
        $adapters = $container->findTaggedServiceIds('ds_discovery.adapter');

        foreach ($adapters as $id => $tags) {
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
