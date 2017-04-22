<?php

namespace Ds\Component\Security\Bridge\Symfony\Bundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\Config\FileLocator;
use Ds\Component\Security\Acl\Permission;

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
        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('security.yml');

        $container->prependExtensionConfig('ds_security', [
            'token' => [
                'ip' => false,
                'client' => false,
                'uuid' => false,
                'identity' => false,
                'modifier' => false
            ]
        ]);

        if ($container->getExtensionConfig('dunglas_action')) {
            $container->prependExtensionConfig('dunglas_action', [
                'directories' => [
                    __DIR__.'/../{Controller,Action,Command,EventSubscriber,Service}'
                ]
            ]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration;
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        $this->loadToken($config['token'] ?? [], $container);
        $this->loadAcl($config['acl'] ?? [], $container);
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
     * Load acl
     *
     * @param array $config
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     */
    protected function loadAcl(array $config, ContainerBuilder $container)
    {
        $this->loadPermissions($config['permissions'] ?? [], $container);
    }

    /**
     * Load permissions
     *
     * @param array $config
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     */
    protected function loadPermissions(array $config, ContainerBuilder $container)
    {
        $permissions = [];

        foreach ($config as $item) {
            $type = $item['type'] ?? null;
            $subject = $item['subject'] ?? null;
            $attributes = $item['attributes'] ?? [];

            if (array_key_exists('entity', $item)) {
                $type = Permission::ENTItY;
                $subject = $item['entity'];
            } elseif (array_key_exists('field', $item)) {
                $type = Permission::FIELD;
                $subject = $item['field'];
            }

            $permission = new Permission($type, $subject, $attributes);
            $permissions[] = $permission->toArray();
        }

        $container
            ->findDefinition('ds_security.collection.permission')
            ->addArgument($permissions);
    }
}
