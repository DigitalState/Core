<?php

namespace Ds\Component\System\DependencyInjection\Compiler;

use Ds\Component\System\Collection\ServiceCollection;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class ServicePass
 *
 * @package Ds\Component\System
 */
final class ServicePass implements CompilerPassInterface
{
    /**
     * Process
     *
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        $definition = $container->findDefinition(ServiceCollection::class);
        $services = $container->findTaggedServiceIds('ds_system.service');

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
