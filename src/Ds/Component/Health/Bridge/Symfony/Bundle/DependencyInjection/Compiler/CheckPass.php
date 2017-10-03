<?php

namespace Ds\Component\Health\Bridge\Symfony\Bundle\DependencyInjection\Compiler;

use LogicException;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class CheckPass
 *
 * @package Ds\Component\Health
 */
class CheckPass implements CompilerPassInterface
{
    /**
     * Process
     *
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     * @throws \LogicException
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->has('ds_health.collection.check')) {
            return;
        }

        $collection = $container->findDefinition('ds_health.collection.check');
        $checks = $container->findTaggedServiceIds('ds_health.check');

        foreach ($checks as $id => $tags) {
            foreach ($tags as $tag) {
                if (!array_key_exists('alias', $tag)) {
                    throw new LogicException('Tag attribute is missing.');
                }

                $check = $container->findDefinition($id);
                $check->addMethodCall('setAlias', [$tag['alias']]);
                $collection->addMethodCall('set', [$tag['alias'], new Reference($id)]);
            }
        }
    }
}
