<?php

namespace Ds\Component\Statistic\Bridge\Symfony\Bundle\DependencyInjection\Compiler;

use LogicException;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class StatPass
 *
 * @package Ds\Component\Statistic
 */
class StatPass implements CompilerPassInterface
{
    /**
     * Process
     *
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     * @throws \LogicException
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->has('ds_statistic.collection.stat')) {
            return;
        }

        $collection = $container->findDefinition('ds_statistic.collection.stat');
        $stats = $container->findTaggedServiceIds('ds_statistic.stat');

        foreach ($stats as $id => $tags) {
            foreach ($tags as $tag) {
                if (!array_key_exists('alias', $tag)) {
                    throw new LogicException('Tag attribute is missing.');
                }

                $stat = $container->findDefinition($id);
                $stat->addMethodCall('setAlias', [$tag['alias']]);
                $collection->addMethodCall('set', [$tag['alias'], new Reference($id)]);
            }
        }
    }
}
