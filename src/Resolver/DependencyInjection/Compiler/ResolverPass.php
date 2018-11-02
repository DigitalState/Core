<?php

namespace Ds\Component\Resolver\DependencyInjection\Compiler;

use Ds\Component\Resolver\Collection\ResolverCollection;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class ResolverPass
 *
 * @package Ds\Component\Resolver
 */
final class ResolverPass implements CompilerPassInterface
{
    /**
     * Process
     *
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->has(ResolverCollection::class)) {
            return;
        }

        $definition = $container->findDefinition(ResolverCollection::class);
        $services = $container->findTaggedServiceIds('ds_resolver.resolver');

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
