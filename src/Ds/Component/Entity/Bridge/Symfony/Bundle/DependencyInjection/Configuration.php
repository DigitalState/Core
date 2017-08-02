<?php

namespace Ds\Component\Entity\Bridge\Symfony\Bundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 *
 * @package Ds\Component\Entity
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $builder = new TreeBuilder;
        $node = $builder->root('ds_entity');
        $node
            ->children()
                ->append($this->getBehaviorNode())
            ->end();

        return $builder;
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
                ->booleanNode('identitiable')->defaultFalse()->end()
                ->booleanNode('uuidentifiable')->defaultFalse()->end()
            ->end();

        return $node;
    }
}
