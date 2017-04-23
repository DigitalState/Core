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
                ->append($this->getAclNode())
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
                ->booleanNode('ip')
                    ->defaultFalse()
                    ->treatNullLike(false)
                ->end()
                ->booleanNode('client')
                    ->defaultFalse()
                    ->treatNullLike(false)
                ->end()
                ->booleanNode('uuid')
                    ->defaultFalse()
                    ->treatNullLike(false)
                ->end()
                ->booleanNode('identity')
                    ->defaultFalse()
                    ->treatNullLike(false)
                ->end()
                ->booleanNode('modifier')
                    ->defaultFalse()
                    ->treatNullLike(false)
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
                    ->treatNullLike(false)
                ->end()
                ->booleanNode('anonymous')
                    ->defaultFalse()
                    ->treatNullLike(false)
                ->end()
                ->booleanNode('individual')
                    ->defaultFalse()
                    ->treatNullLike(false)
                ->end()
                ->booleanNode('owner')
                    ->defaultFalse()
                    ->treatNullLike(false)
                ->end()
                ->booleanNode('enabled')
                    ->defaultFalse()
                    ->treatNullLike(false)
                ->end()
            ->end();

        return $node;
    }

    /**
     * Get acl node
     *
     * @return \Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition|\Symfony\Component\Config\Definition\Builder\NodeDefinition
     */
    protected function getAclNode()
    {
        $builder = new TreeBuilder;
        $node = $builder->root('acl');

        $node
            ->children()
                ->arrayNode('permissions')
                    ->useAttributeAsKey('name')
                    ->prototype('array')
                        ->children()
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
                    ->end()
                ->end()
            ->end();

        return $node;
    }
}
