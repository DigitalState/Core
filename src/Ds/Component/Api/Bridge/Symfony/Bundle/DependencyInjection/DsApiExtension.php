<?php

namespace Ds\Component\Api\Bridge\Symfony\Bundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * Class DsApiExtension
 *
 * @package Ds\Component\Api
 */
class DsApiExtension extends Extension implements PrependExtensionInterface
{
    /**
     * {@inheritdoc}
     */
    public function prepend(ContainerBuilder $container)
    {
        $container->prependExtensionConfig('ds_api', [
            'credential' => [
                'username' => null,
                'uuid' => null,
                'roles' => null,
                'identity' => null,
                'identity_uuid' => null
            ],
            'api' => [
                'authentication' => [
                    'host' => null
                ],
                'identities' => [
                    'host' => null
                ],
                'cases' => [
                    'host' => null
                ],
                'services' => [
                    'host' => null
                ],
                'records' => [
                    'host' => null
                ],
                'assets' => [
                    'host' => null
                ],
                'cms' => [
                    'host' => null
                ],
                'camunda' => [
                    'host' => null
                ],
                'formio' => [
                    'host' => null
                ]
            ]
        ]);
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
        $loader->load('collections.yml');
        $loader->load('resolvers.yml');
        $loader->load('services.yml');

        // @todo Move this config -> parameters logic to a common trait in the config component bridge
        $container->setParameter('ds_config.configs.ds_api.credential.username', $config['credential']['username']);
        $container->setParameter('ds_config.configs.ds_api.credential.uuid', $config['credential']['uuid']);
        $container->setParameter('ds_config.configs.ds_api.credential.roles', $config['credential']['roles']);
        $container->setParameter('ds_config.configs.ds_api.credential.identity', $config['credential']['identity']);
        $container->setParameter('ds_config.configs.ds_api.credential.identity_uuid', $config['credential']['identity_uuid']);
        $container->setParameter('ds_config.configs.ds_api.api.authentication.host', $config['api']['authentication']['host']);
        $container->setParameter('ds_config.configs.ds_api.api.identities.host', $config['api']['identities']['host']);
        $container->setParameter('ds_config.configs.ds_api.api.cases.host', $config['api']['cases']['host']);
        $container->setParameter('ds_config.configs.ds_api.api.services.host', $config['api']['services']['host']);
        $container->setParameter('ds_config.configs.ds_api.api.records.host', $config['api']['records']['host']);
        $container->setParameter('ds_config.configs.ds_api.api.assets.host', $config['api']['assets']['host']);
        $container->setParameter('ds_config.configs.ds_api.api.cms.host', $config['api']['cms']['host']);
        $container->setParameter('ds_config.configs.ds_api.api.camunda.host', $config['api']['camunda']['host']);
        $container->setParameter('ds_config.configs.ds_api.api.formio.host', $config['api']['formio']['host']);
    }
}
