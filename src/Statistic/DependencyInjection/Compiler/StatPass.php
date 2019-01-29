<?php

namespace Ds\Component\Statistic\DependencyInjection\Compiler;

use Ds\Component\Statistic\Collection\StatCollection;
use LogicException;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class StatPass
 *
 * @package Ds\Component\Statistic
 */
final class StatPass implements CompilerPassInterface
{
    /**
     * Process
     *
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     * @throws \LogicException
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->has(StatCollection::class)) {
            return;
        }

        $collection = $container->findDefinition(StatCollection::class);
        $stats = $container->findTaggedServiceIds('ds_statistic.stat');

        foreach ($stats as $id => $tags) {
            foreach ($tags as $tag) {
                if (!array_key_exists('alias', $tag)) {
                    throw new LogicException('Tag attribute "alias" is missing.');
                }

                $stat = $container->findDefinition($id);
                $stat->addMethodCall('setAlias', [$tag['alias']]);
                $collection->addMethodCall('set', [$tag['alias'], new Reference($id)]);
            }
        }
    }
}
