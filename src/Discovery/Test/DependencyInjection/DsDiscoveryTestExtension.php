<?php

namespace Ds\Component\Discovery\Test\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * Class DsDiscoveryTestExtension
 *
 * @package Ds\Component\Discovery
 */
final class DsDiscoveryTestExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration;
        $config = $this->processConfiguration($configuration, $configs);

        if ('vendor/bin/behat' === $_SERVER['PHP_SELF']) {
            $container->setParameter('ds_discovery.host', $config['host']);
        }
    }
}
