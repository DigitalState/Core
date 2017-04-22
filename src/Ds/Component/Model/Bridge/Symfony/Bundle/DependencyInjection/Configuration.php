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
                ->arrayNode('behavior')
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
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
