<?php

namespace Ds\Component\Discovery\DependencyInjection;

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

        $container->setParameter('ds_discovery.host', $config['host']);
        $container->setParameter('ds_discovery.credential', $config['credential']);
    }
}
