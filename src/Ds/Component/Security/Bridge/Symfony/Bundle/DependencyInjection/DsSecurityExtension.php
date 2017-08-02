<?php

namespace Ds\Component\Security\Bridge\Symfony\Bundle\DependencyInjection;

use Ds\Component\Security\Model\Permission;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

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
                'individual' => false
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
        $loader->load('serializers.yml');
        $loader->load('services.yml');
        $loader->load('voters.yml');

        $configuration = new Configuration;
        $config = $this->processConfiguration($configuration, $configs);

        $this->loadAcl($config['acl'], $container);
        $this->loadToken($config['token'], $container);
        $this->loadFilter($config['filter'], $container);
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
            $container->removeDefinition('ds_security.event_listener.acl.entity');
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
     * Load filter
     *
     * @param array $filter
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     */
    protected function loadFilter(array $filter, ContainerBuilder $container)
    {
        foreach ($filter as $property => $enabled) {
            if (!$enabled) {
                $container->removeDefinition(sprintf('ds_security.doctrine.orm.query_extension.%s', $property));
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

            if (!array_key_exists('title', $element)) {
                $element['title'] = null;
            }

            if (!array_key_exists('type', $element)) {
                $element['type'] = null;
            }

            if (!array_key_exists('value', $element)) {
                $element['value'] = null;
            }

            if (!array_key_exists('attributes', $element)) {
                $element['attributes'] = [];
            }

            foreach (['custom', 'entity', 'property'] as $type) {
                if (array_key_exists($type, $element)) {
                    $element['type'] = constant(Permission::class.'::'.strtoupper($type));
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
