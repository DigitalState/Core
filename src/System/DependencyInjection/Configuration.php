<?php

namespace Ds\Component\System\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 *
 * @package Ds\Component\System
 */
final class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $builder = new TreeBuilder;
        $node = $builder->root('ds_system');
        $node
            ->children()
                ->scalarNode('namespace')
                ->end()
                ->arrayNode('system')
                    ->children()
                        ->scalarNode('username')
                        ->end()
                        ->scalarNode('password')
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $builder;
    }
}
