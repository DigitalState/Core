<?php

namespace Ds\Component\Security\Bridge\Symfony\Bundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\Config\FileLocator;
use Ds\Component\Security\Model\Permission;

/**
 * Class DsSecurityExtension
 */
class DsSecurityExtension extends Extension implements PrependExtensionInterface
{
    /**
     * {@inheritdoc}
     */
    public function prepend(ContainerBuilder $container)
    {
        $container->prependExtensionConfig('ds_security', [
            'acl' => false,
            'token' => [
                'uuid' => true,
                'identity' => true,
                'identity_uuid' => true,
                'ip' => false,
                'client' => false,
                'modifier' => false
            ],
            'filter' => [
                'identity' => false,
                'anonymous' => false,
                'individual' => false,
                'owner' => false,
                'enabled' => false
            ],
            'permissions' => []
        ]);

        if ($container->getExtensionConfig('dunglas_action')) {
            $container->prependExtensionConfig('dunglas_action', [
                'directories' => [
                    __DIR__.'/../Action'
                ]
            ]);
        }

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('config.yml');
        $loader->load('security.yml');
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
        $loader->load('collections.yml');
        $loader->load('doctrine.yml');
        $loader->load('event_listeners.yml');
        $loader->load('repositories.yml');
        $loader->load('serializers.yml');
        $loader->load('services.yml');
        $loader->load('voters.yml');

        $this->loadAcl($config['acl'], $container);
        $this->loadToken($config['token'], $container);
        $this->loadFilter($config['filter'], $container);
        $this->loadPermissions($config['permissions'], $container);
    }

    /**
     * Load acl
     *
     * @param boolean $enabled
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     */
    protected function loadAcl($enabled, ContainerBuilder $container)
    {
        if (!$enabled) {
            $container->removeDefinition('ds_security.serializer.normalizer.acl');
            $container->removeDefinition('ds_security.serializer.jsonld.normalizer.acl');
        }
    }

    /**
     * Load token
     *
     * @param array $config
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     */
    protected function loadToken(array $config, ContainerBuilder $container)
    {
        foreach ($config as $token => $enabled) {
            if (!$enabled) {
                $container->removeDefinition(sprintf('ds_security.event_listener.token.%s', $token));
            }
        }
    }

    /**
     * Load filter
     *
     * @param array $config
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     */
    protected function loadFilter(array $config, ContainerBuilder $container)
    {
        foreach ($config as $filter => $enabled) {
            if (!$enabled) {
                $container->removeDefinition(sprintf('ds_security.doctrine.orm.query_extension.%s', $filter));
            }
        }
    }

    /**
     * Load permissions
     *
     * @param array $config
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     */
    protected function loadPermissions(array $config, ContainerBuilder $container)
    {
        $definition = $container->findDefinition('ds_security.collection.permission');

        foreach ($config as $key => $item) {
            $title = $item['title'] ?? null;
            $type = $item['type'] ?? null;
            $subject = $item['subject'] ?? null;
            $attributes = $item['attributes'] ?? [];

            if (array_key_exists('entity', $item)) {
                $type = Permission::ENTITY;
                $subject = $item['entity'];
            } elseif (array_key_exists('property', $item)) {
                $type = Permission::PROPERTY;
                $subject = $item['property'];
            }

            $permission = new Permission($title, $key, $type, $subject, $attributes);
            $definition->addMethodCall('set', [$key, (array)$permission->toObject()]);
        }
    }
}
