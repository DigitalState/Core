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
                ->arrayNode('host')
                    ->children()
                    ->scalarNode('authentication')->end()
                    ->scalarNode('identities')->end()
                    ->scalarNode('cases')->end()
                    ->scalarNode('services')->end()
                    ->scalarNode('records')->end()
                    ->scalarNode('assets')->end()
                    ->scalarNode('cms')->end()
                    ->end()
                ->end()
            ->end();

        return $builder;
    }
}
