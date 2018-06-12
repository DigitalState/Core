<?php

namespace Ds\Component\Tenant\Bridge\Symfony\Bundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 *
 * @package Ds\Component\Tenant
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $builder = new TreeBuilder;
        $node = $builder->root('ds_tenant');
        $node
            ->children()
                ->arrayNode('tenant')
                    ->children()
                        ->scalarNode('default')
                            ->defaultNull()
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $builder;
    }
}
