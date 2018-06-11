<?php

namespace Ds\Component\Identity\Bridge\Symfony\TestBundle\DependencyInjection;

use Ds\Component\Identity\Model\Identity;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 *
 * @package Ds\Component\Identity
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $builder = new TreeBuilder;
        $node = $builder->root('ds_identity_test');
        $node
            ->children()
                ->arrayNode('users')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('username')
                            ->end()
                            ->arrayNode('roles')
                            ->end()
                            ->scalarNode('uuid')
                            ->end()
                            ->arrayNode('identity')
                                ->children()
                                    ->arrayNode('roles')
                                    ->end()
                                    ->enumNode('type')
                                        ->values([Identity::SYSTEM, Identity::STAFF, Identity::ORGANIZATION, Identity::INDIVIDUAL, Identity::ANONYMOUS])
                                    ->end()
                                    ->scalarNode('uuid')
                                    ->end()
                                ->end()
                            ->end()
                            ->scalarNode('tenant')
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $builder;
    }
}
