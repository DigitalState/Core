<?php

namespace Ds\Component\Log\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 *
 * @package Ds\Component\Log
 */
final class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $builder = new TreeBuilder;
        $node = $builder->root('ds_log');

        return $builder;
    }
}
