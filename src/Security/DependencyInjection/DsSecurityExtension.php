<?php

namespace Ds\Component\Security\DependencyInjection;

use Ds\Component\Security\Model\Permission;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * Class DsSecurityExtension
 *
 * @package Ds\Component\Security
 */
class DsSecurityExtension extends Extension implements PrependExtensionInterface
{
    /**
     * {@inheritdoc}
     */
    public function prepend(ContainerBuilder $container)
    {
        $container->prependExtensionConfig('ds_security', [
            'acl' => true,
            'token' => [
                'uuid' => true,
                'ip' => false,
                'client' => false,
                'modifier' => true
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
        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('parameters.yml');
        $loader->load('api_filters.yml');
        $loader->load('collections.yml');
        $loader->load('doctrine.yml');
        $loader->load('event_listeners.yml');
        $loader->load('repositories.yml');
        $loader->load('resolvers.yml');
        $loader->load('serializers.yml');
        $loader->load('services.yml');
        $loader->load('tenants.yml');
        $loader->load('voters.yml');

        $configuration = new Configuration;
        $config = $this->processConfiguration($configuration, $configs);

        $this->loadAcl($config['acl'], $container);
        $this->loadToken($config['token'], $container);
        $this->loadPermissions($config['permissions'], $container);
    }

    /**
     * Load acl
     *
     * @param boolean $acl
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     */
    protected function loadAcl($acl, ContainerBuilder $container)
    {
        if (!$acl) {
            $container->removeDefinition('ds_security.doctrine.orm.query_extension.enabled');
            $container->removeDefinition('ds_security.doctrine.orm.query_extension.deleted');
            $container->removeDefinition('ds_security.doctrine.orm.query_extension.permission.entity');
            $container->removeDefinition('ds_security.event_listener.acl.permission.entity');
            $container->removeDefinition('ds_security.event_listener.acl.deleted');
            $container->removeDefinition('ds_security.event_listener.acl.enabled');
            $container->removeDefinition('ds_security.serializer.normalizer.acl.property');
            $container->removeDefinition('ds_security.serializer.jsonld.normalizer.acl.property');
        }
    }

    /**
     * Load token
     *
     * @param array $token
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     */
    protected function loadToken(array $token, ContainerBuilder $container)
    {
        foreach ($token as $property => $enabled) {
            if (!$enabled) {
                $container->removeDefinition(sprintf('ds_security.event_listener.token.%s', $property));
            }
        }
    }

    /**
     * Load permissions
     *
     * @param array $permissions
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     */
    protected function loadPermissions(array $permissions, ContainerBuilder $container)
    {
        foreach ($permissions as $key => $element) {
            $element['key'] = $key;

            if (!array_key_exists('attributes', $element)) {
                $element['attributes'] = [];
            }

            if (!array_key_exists('type', $element)) {
                $element['type'] = null;
            }

            if (!array_key_exists('value', $element)) {
                $element['value'] = null;
            }

            if (!array_key_exists('title', $element)) {
                $element['title'] = null;
            }

            foreach ([Permission::GENERIC, Permission::ENTITY, Permission::PROPERTY] as $type) {
                if (array_key_exists($type, $element)) {
                    $element['type'] = $type;
                    $element['value'] = $element[$type];
                    unset($element[$type]);
                }
            }

            $permissions[$key] = $element;
        }

        $definition = $container->findDefinition('ds_security.collection.permission');
        $definition->setArguments([$permissions]);
    }
}
