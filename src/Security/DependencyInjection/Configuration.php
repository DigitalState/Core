<?php

namespace Ds\Component\Security\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 *
 * @package Ds\Component\Security
 */
final class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $builder = new TreeBuilder;
        $node = $builder->root('ds_security');
        $node
            ->children()
                ->arrayNode('token')
                    ->children()
                        ->booleanNode('uuid')
                            ->defaultFalse()
                        ->end()
                        ->booleanNode('ip')
                            ->defaultFalse()
                        ->end()
                        ->booleanNode('client')
                            ->defaultFalse()
                        ->end()
                        ->booleanNode('modifier')
                            ->defaultFalse()
                        ->end()
                        ->arrayNode('identity')
                            ->children()
                                ->booleanNode('business_units')
                                    ->defaultFalse()
                                ->end()
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
