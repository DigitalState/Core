<?php

namespace Ds\Component\Identity\Test\DependencyInjection;

use Ds\Component\Security\Model\User;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * Class DsIdentityTestExtension
 *
 * @package Ds\Component\Identity
 */
class DsIdentityTestExtension extends Extension implements PrependExtensionInterface
{
    /**
     * {@inheritdoc}
     */
    public function prepend(ContainerBuilder $container)
    {
        $container->prependExtensionConfig('ds_identity_test', [
            'users' => []
        ]);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('config.yml');
    }

    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('parameters.yml');
        $loader->load('collections.yml');

        $configuration = new Configuration;
        $config = $this->processConfiguration($configuration, $configs);

        $this->loadUsers($config['users'], $container);
    }

    /**
     * Load test users
     *
     * @param array $users
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     */
    protected function loadUsers(array $users, ContainerBuilder $container)
    {
        $definition = $container->findDefinition('ds_identity_test.collection.user');
        $definition->setArguments([$users]);
    }
}
