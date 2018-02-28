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
                ->arrayNode('user')
                    ->children()
                        ->scalarNode('username')->end()
                        ->scalarNode('uuid')->end()
                        ->scalarNode('roles')->end()
                        ->scalarNode('identity')->end()
                        ->scalarNode('identity_uuid')->end()
                    ->end()
                ->end()
            ->end();

        return $builder;
    }
}
