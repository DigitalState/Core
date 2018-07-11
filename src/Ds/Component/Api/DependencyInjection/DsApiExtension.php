<?php

namespace Ds\Component\Api\DependencyInjection;

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
            'user' => [
                'username' => null,
                'password' => null,
                'uuid' => null,
                'roles' => null,
                'identity' => null,
                'identity_uuid' => null
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
        $loader->load('tenants.yml');

        // @todo Move this config -> parameters logic to a common trait in the config component bridge
        $container->setParameter('ds_config.configs.ds_api.user.username', $config['user']['username']);
        $container->setParameter('ds_config.configs.ds_api.user.password', $config['user']['password']);
        $container->setParameter('ds_config.configs.ds_api.user.uuid', $config['user']['uuid']);
        $container->setParameter('ds_config.configs.ds_api.user.roles', $config['user']['roles']);
        $container->setParameter('ds_config.configs.ds_api.user.identity', $config['user']['identity']);
        $container->setParameter('ds_config.configs.ds_api.user.identity_uuid', $config['user']['identity_uuid']);
    }
}
