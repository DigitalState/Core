<?php

namespace Ds\Component\Log\DependencyInjection;

use Ds\Component\Log\Monolog\Processor\AppProcessor;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * Class DsLogExtension
 *
 * @package Ds\Component\Log
 */
final class DsLogExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yaml');

        $configuration = new Configuration;
        $config = $this->processConfiguration($configuration, $configs);

        $definition = $container->getDefinition(AppProcessor::class);
        $definition->addArgument($config['app']);
    }
}
