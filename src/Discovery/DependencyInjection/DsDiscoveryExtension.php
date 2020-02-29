<?php

namespace Ds\Component\Discovery\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader;

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

        $container->setParameter('ds_discovery.adapter', $config['adapter']);
        $container->setParameter('ds_discovery.consul.host', $config['consul']['host']);
        $container->setParameter('ds_discovery.consul.credentials', $config['consul']['credentials']);
        $container->setParameter('ds_discovery.env.services', $config['env']['services']);
        $container->setParameter('ds_discovery.env.configs', $config['env']['configs']);
    }
}
