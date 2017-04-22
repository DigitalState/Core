<?php

namespace Ds\Component\Model\Bridge\Symfony\Bundle\DependencyInjection;

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
        $rootNode = $treeBuilder->root('ds_model');

        $rootNode
            ->children()
                ->append($this->getBehaviorNode())
            ->end();

        return $treeBuilder;
    }

    /**
     * Get behavior node
     *
     * @return \Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition|\Symfony\Component\Config\Definition\Builder\NodeDefinition
     */
    protected function getBehaviorNode()
    {
        $builder = new TreeBuilder;
        $node = $builder->root('behavior');

        $node
            ->children()
                ->booleanNode('localizable')
                    ->defaultFalse()
                    ->treatNullLike(false)
                ->end()
                ->booleanNode('translatable')
                    ->defaultFalse()
                    ->treatNullLike(false)
                ->end()
                ->booleanNode('uuidentifiable')
                    ->defaultFalse()
                    ->treatNullLike(false)
                ->end()
            ->end();

        return $node;
    }
}