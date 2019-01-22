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
        $definition = $container->findDefinition(ResolverCollection::class);
        $services = $container->findTaggedServiceIds('ds_resolver.resolver');
        $items = [];

        foreach ($services as $id => $tags) {
            foreach ($tags as $tag) {
                $items[] = [
                    'id' => $id,
                    'priority' => array_key_exists('priority', $tag) ? $tag['priority'] : 0,
                    'alias' => array_key_exists('alias', $tag) ? $tag['alias'] : null
                ];
            }
        }

        usort($items, function($a, $b) {
            return
                $a['priority'] === $b['priority'] ? 0
                    : $a['priority'] < $b['priority'] ? -1
                    : 1;
        });

        foreach ($items as $item) {
            if (null !== $item['alias']) {
                $definition->addMethodCall('set', [$item['alias'], new Reference($item['id'])]);
            } else {
                $definition->addMethodCall('add', [new Reference($item['id'])]);
            }
        }
    }
}
