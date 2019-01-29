<?php

namespace Ds\Component\Acl\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 *
 * @package Ds\Component\Acl
 */
final class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $builder = new TreeBuilder;
        $node = $builder->root('ds_acl');
        $node
            ->children()
                ->booleanNode('enabled')
                    ->defaultTrue()
                ->end()
                ->arrayNode('entities')
                    ->scalarPrototype()
                    ->end()
                ->end()
                ->arrayNode('permissions')
                    ->useAttributeAsKey('name')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('title')
                            ->end()
                            ->enumNode('type')
                                ->values(['generic', 'entity', 'property'])
                            ->end()
                            ->scalarNode('value')
                            ->end()
                            ->arrayNode('attributes')
                                ->prototype('enum')
                                ->values(['BROWSE', 'READ', 'EDIT', 'ADD', 'DELETE', 'EXECUTE'])
                                ->end()
                            ->end()
                            ->scalarNode('generic')
                            ->end()
                            ->scalarNode('entity')
                            ->end()
                            ->scalarNode('property')
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $builder;
    }
}
