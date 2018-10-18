<?php

namespace Ds\Component\Workflow\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 *
 * @package Ds\Component\Workflow
 */
final class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder() : TreeBuilder
    {
        $builder = new TreeBuilder;
        $node = $builder->root('ds_workflow');

        return $builder;
    }
}
