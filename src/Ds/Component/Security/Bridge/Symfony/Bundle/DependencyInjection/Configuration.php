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
                ->append($this->getAclNode())
            ->end();

        return $treeBuilder;
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
