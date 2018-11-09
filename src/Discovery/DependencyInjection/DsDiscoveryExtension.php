<?php

namespace Ds\Component\Discovery\DependencyInjection;

use Ds\Component\Discovery\Repository\ConfigRepository;
use Ds\Component\Discovery\Repository\ServiceRepository;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * Class DsDiscoveryExtension
 *
 * @package Ds\Component\Discovery
 */
final class DsDiscoveryExtension extends Extension
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

        $repositories = [
            ConfigRepository::class,
            ServiceRepository::class
        ];

        foreach ($repositories as $repository) {
            $definition = $container->getDefinition($repository);
            $definition->addArgument($config['host']);
            $definition->addArgument($config['credential']);
        }
    }
}
