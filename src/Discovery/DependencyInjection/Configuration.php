<?php

namespace Ds\Component\Discovery\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 *
 * @package Ds\Component\Discovery
 */
final class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $builder = new TreeBuilder;
        $node = $builder->root('ds_discovery');
        $node
            ->children()
                ->scalarNode('host')
                ->end()
                ->scalarNode('credential')
                ->end()
            ->end();

        return $builder;
    }
}
