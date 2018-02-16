<?php

namespace Ds\Component\Security\Bridge\Symfony\Bundle\DependencyInjection;

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
                ->booleanNode('acl')->defaultFalse()->end()
                ->append($this->getTokenNode())
                ->append($this->getFilterNode())
                ->append($this->getPermissionsNode())
            ->end();

        return $builder;
    }

    /**
     * Get token node
     *
     * @return \Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition|\Symfony\Component\Config\Definition\Builder\NodeDefinition
     */
    protected function getTokenNode()
    {
        $builder = new TreeBuilder;
        $node = $builder->root('token');
        $node
            ->children()
                ->booleanNode('uuid')->defaultFalse()->end()
                ->booleanNode('identity')->defaultFalse()->end()
                ->booleanNode('identity_uuid')->defaultFalse()->end()
                ->booleanNode('ip')->defaultFalse()->end()
                ->booleanNode('client')->defaultFalse()->end()
                ->booleanNode('roles')->defaultFalse()->end()
                ->booleanNode('modifier')->defaultFalse()->end()
            ->end();

        return $node;
    }

    /**
     * Get filter node
     *
     * @return \Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition|\Symfony\Component\Config\Definition\Builder\NodeDefinition
     */
    protected function getFilterNode()
    {
        $builder = new TreeBuilder;
        $node = $builder->root('filter');
        $node
            ->children()
                ->booleanNode('identity')->defaultFalse()->end()
                ->booleanNode('anonymous')->defaultFalse()->end()
                ->booleanNode('individual')->defaultFalse()->end()
            ->end();

        return $node;
    }

    /**
     * Get permissions node
     *
     * @return \Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition|\Symfony\Component\Config\Definition\Builder\NodeDefinition
     */
    protected function getPermissionsNode()
    {
        $builder = new TreeBuilder;
        $node = $builder->root('permissions');
        $node
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
                ->end();

        return $node;
    }
}
