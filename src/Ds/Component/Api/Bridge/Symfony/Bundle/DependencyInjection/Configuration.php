<?php

namespace Ds\Component\Api\Bridge\Symfony\Bundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 *
 * @package Ds\Component\Api
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $builder = new TreeBuilder;
        $node = $builder->root('ds_api');
        $node
            ->children()
                ->arrayNode('credential')
                    ->children()
                        ->scalarNode('username')->end()
                        ->scalarNode('uuid')->end()
                        ->scalarNode('roles')->end()
                        ->scalarNode('identity')->end()
                        ->scalarNode('identity_uuid')->end()
                    ->end()
                ->end()
                ->arrayNode('api')
                    ->children()
                        ->arrayNode('assets')
                            ->children()
                                ->scalarNode('host')->end()
                            ->end()
                        ->end()
                        ->arrayNode('authentication')
                            ->children()
                                ->scalarNode('host')->end()
                            ->end()
                        ->end()
                        ->arrayNode('camunda')
                            ->children()
                                ->scalarNode('host')->end()
                            ->end()
                        ->end()
                        ->arrayNode('cases')
                            ->children()
                                ->scalarNode('host')->end()
                            ->end()
                        ->end()
                        ->arrayNode('cms')
                            ->children()
                                ->scalarNode('host')->end()
                            ->end()
                        ->end()
                        ->arrayNode('formio')
                            ->children()
                                ->scalarNode('host')->end()
                            ->end()
                        ->end()
                        ->arrayNode('identities')
                            ->children()
                                ->scalarNode('host')->end()
                            ->end()
                        ->end()
                        ->arrayNode('records')
                            ->children()
                                ->scalarNode('host')->end()
                            ->end()
                        ->end()
                        ->arrayNode('services')
                            ->children()
                                ->scalarNode('host')->end()
                            ->end()
                        ->end()
                        ->arrayNode('tasks')
                            ->children()
                                ->scalarNode('host')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $builder;
    }
}
