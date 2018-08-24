<?php

namespace Ds\Component\Audit\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 *
 * @package Ds\Component\Audit
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $builder = new TreeBuilder;
        $node = $builder->root('ds_audit');
        $node
            ->children()
                ->arrayNode('audit')
                    ->children()
                        ->scalarNode('owner')->end()
                        ->scalarNode('owner_uuid')->end()
                    ->end()
                ->end()
            ->end();

        return $builder;
    }
}
