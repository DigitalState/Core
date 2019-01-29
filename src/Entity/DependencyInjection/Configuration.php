<?php

namespace Ds\Component\Entity\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 *
 * @package Ds\Component\Entity
 */
final class Configuration implements ConfigurationInterface
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
                ->booleanNode('uuidentifiable')
                    ->defaultFalse()
                ->end()
                ->booleanNode('custom_identifiable')
                    ->defaultFalse()
                ->end()
            ->end();

        return $builder;
    }
}
