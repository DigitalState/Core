<?php

namespace Ds\Component\Audit\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * Class DsAuditExtension
 *
 * @package Ds\Component\Audit
 */
class DsAuditExtension extends Extension implements PrependExtensionInterface
{
    /**
     * {@inheritdoc}
     */
    public function prepend(ContainerBuilder $container)
    {
        $container->prependExtensionConfig('ds_audit', [
            'audit' => [
                'owner' => null,
                'owner_uuid' => null
            ]
        ]);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('config.yml');
    }

    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration;
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('parameters.yml');
        $loader->load('api_filters.yml');
        $loader->load('event_listeners.yml');
        $loader->load('repositories.yml');
        $loader->load('services.yml');

        // @todo Move this config -> parameters logic to a common trait in the config component bridge
        $container->setParameter('ds_config.configs.ds_audit.audit.owner', $config['audit']['owner']);
        $container->setParameter('ds_config.configs.ds_audit.audit.owner_uuid', $config['audit']['owner_uuid']);
    }
}
