<?php

namespace Ds\Component\Security\Bridge\Symfony\Bundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder;
        $rootNode = $treeBuilder->root('ds_security');
        $rootNode
            ->children()
                ->append($this->getTokenNode())
                ->append($this->getPermissionsNode())
                ->append($this->getFilterNode())
            ->end();

        return $treeBuilder;
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
                ->booleanNode('uuid')
                    ->defaultFalse()
                    ->treatNullLike(true)
                ->end()
                ->booleanNode('identity')
                    ->defaultFalse()
                    ->treatNullLike(true)
                ->end()
                ->booleanNode('identity_uuid')
                    ->defaultFalse()
                    ->treatNullLike(true)
                ->end()
                ->booleanNode('ip')
                    ->defaultFalse()
                    ->treatNullLike(true)
                ->end()
                ->booleanNode('client')
                    ->defaultFalse()
                    ->treatNullLike(true)
                ->end()
                ->booleanNode('modifier')
                    ->defaultFalse()
                    ->treatNullLike(true)
                ->end()
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
                ->booleanNode('identity')
                    ->defaultFalse()
                    ->treatNullLike(true)
                ->end()
                ->booleanNode('anonymous')
                    ->defaultFalse()
                    ->treatNullLike(true)
                ->end()
                ->booleanNode('individual')
                    ->defaultFalse()
                    ->treatNullLike(true)
                ->end()
                ->booleanNode('owner')
                    ->defaultFalse()
                    ->treatNullLike(true)
                ->end()
                ->booleanNode('enabled')
                    ->defaultFalse()
                    ->treatNullLike(true)
                ->end()
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
                    ->scalarNode('title')
                    ->end()
                    ->enumNode('type')
                        ->values([ 'entity', 'field' ])
                    ->end()
                    ->scalarNode('subject')
                    ->end()
                    ->arrayNode('attributes')
                        ->isRequired()
                        ->requiresAtLeastOneElement()
                        ->prototype('scalar')
                    ->end()
                    ->end()
                    ->scalarNode('entity')
                    ->end()
                    ->scalarNode('field')
                    ->end()
                ->end()
            ->end();

        return $node;
    }
}
