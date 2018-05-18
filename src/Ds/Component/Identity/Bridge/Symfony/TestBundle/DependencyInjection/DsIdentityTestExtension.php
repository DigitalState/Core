<?php

namespace Ds\Component\Identity\Bridge\Symfony\TestBundle\DependencyInjection;

use Ds\Component\Security\User\User;
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
            'identity' => []
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

        $this->loadIdentity($config['identity'], $container);
    }

    /**
     * Load test identity elements
     *
     * @param array $identity
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     */
    protected function loadIdentity(array $identity, ContainerBuilder $container)
    {
        $definition = $container->findDefinition('ds_identity_test.collection.identity');
        $definition->setArguments([$identity]);
    }
}
