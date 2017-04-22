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
        $config = $container->getExtensionConfig('dunglas_action');

        if (!$config) {
            return;
        }

        $container->prependExtensionConfig('dunglas_action', [
            'directories' => [
                __DIR__.'/../{Controller,Action,Command,EventSubscriber,Service}'
            ]
        ]);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
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
        $loader->load('services.yml');

        $this->loadAcl($container, $config['acl'] ?? []);
    }

    /**
     * Load acl
     *
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     * @param array $config
     */
    protected function loadAcl(ContainerBuilder $container, array $config)
    {
        $this->loadPermissions($container, $config['permissions'] ?? []);
    }

    /**
     * Load permissions
     *
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     * @param array $config
     */
    protected function loadPermissions(ContainerBuilder $container, array $config)
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
