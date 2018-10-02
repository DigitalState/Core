<?php

namespace Ds\Component\Config\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 *
 * @package Ds\Component\Config
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $builder = new TreeBuilder;
        $node = $builder->root('ds_config');
        $node
            ->children()
                ->arrayNode('configs')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('title')
                            ->end()
                            ->scalarNode('key')
                            ->end()
                            ->booleanNode('encrypt')
                                ->defaultFalse()
                            ->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('parameters')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('title')
                            ->end()
                            ->scalarNode('key')
                            ->end()
                            ->booleanNode('encrypt')
                                ->defaultFalse()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $builder;
    }
}
