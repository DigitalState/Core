<?php

namespace Ds\Component\Tenant\DependencyInjection\Compiler;

use Ds\Component\Tenant\Collection\LoaderCollection;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class LoaderPass
 *
 * @package Ds\Component\Tenant
 */
final class LoaderPass implements CompilerPassInterface
{
    /**
     * Add tagged tenant loader services to the loader collection
     *
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        $definition = $container->findDefinition(LoaderCollection::class);
        $services = $container->findTaggedServiceIds('ds_tenant.loader');
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
