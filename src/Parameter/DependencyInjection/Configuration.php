<?php

namespace Ds\Component\Parameter\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 *
 * @package Ds\Component\Parameter
 */
final class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $builder = new TreeBuilder;
        $node = $builder->root('ds_parameter');
        $node
            ->children()
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
