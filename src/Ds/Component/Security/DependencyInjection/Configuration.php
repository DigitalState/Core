<?php

namespace Ds\Component\Security\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 *
 * @package Ds\Component\Security
 */
class Configuration implements ConfigurationInterface
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
                ->booleanNode('acl')
                    ->defaultTrue()
                ->end()
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
                    ->end()
                ->end()
                ->arrayNode('filter')
                    ->children()
                        ->booleanNode('identity')
                            ->defaultFalse()
                        ->end()
                        ->booleanNode('anonymous')
                            ->defaultFalse()
                        ->end()
                        ->booleanNode('individual')
                            ->defaultFalse()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('permissions')
                    ->useAttributeAsKey('name')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('title')->end()
                            ->enumNode('type')->values(['generic', 'entity', 'property'])->end()
                            ->scalarNode('value')->end()
                            ->arrayNode('attributes')
                            ->prototype('enum')->values(['BROWSE', 'READ', 'EDIT', 'ADD', 'DELETE', 'EXECUTE'])->end()
                        ->end()
                        ->scalarNode('generic')->end()
                        ->scalarNode('entity')->end()
                        ->scalarNode('property')->end()
                    ->end()
                ->end()
            ->end();

        return $builder;
    }
}
