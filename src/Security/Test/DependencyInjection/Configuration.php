<?php

namespace Ds\Component\Security\Test\DependencyInjection;

use Ds\Component\Security\Model\Identity;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 *
 * @package Ds\Component\Security
 */
final class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $builder = new TreeBuilder;
        $node = $builder->root('ds_security_test');
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
                                    ->arrayNode('business_units')
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
