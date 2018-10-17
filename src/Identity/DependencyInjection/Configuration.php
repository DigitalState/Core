<?php

namespace Ds\Component\Identity\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 *
 * @package Ds\Component\Identity
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $builder = new TreeBuilder;
        $node = $builder->root('ds_identity');
        $node
            ->children()
                ->arrayNode('token')
                    ->children()
                        ->arrayNode('identity')
                            ->children()
                                ->booleanNode('roles')
                                    ->defaultFalse()
                                ->end()
                                ->booleanNode('type')
                                    ->defaultFalse()
                                ->end()
                                ->booleanNode('uuid')
                                    ->defaultFalse()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $builder;
    }
}
