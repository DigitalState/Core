<?php

namespace Ds\Component\Identity\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * Class DsIdentityExtension
 *
 * @package Ds\Component\Identity
 */
class DsIdentityExtension extends Extension implements PrependExtensionInterface
{
    /**
     * {@inheritdoc}
     */
    public function prepend(ContainerBuilder $container)
    {
        $container->prependExtensionConfig('ds_identity', [
            'token' => [
                'identity' => [
                    'roles' => true,
                    'type' => true,
                    'uuid' => true
                ]
            ]
        ]);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
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
        $loader->load('event_listeners.yml');

        $this->loadToken($config['token'], $container);
    }

    /**
     * Load token
     *
     * @param array $token
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     */
    protected function loadToken(array $token, ContainerBuilder $container)
    {
        foreach ($token['identity'] as $property => $enabled) {
            if (!$enabled) {
                $container->removeDefinition(sprintf('ds_identity.event_listener.token.identity.%s', $property));
            }
        }
    }
}
