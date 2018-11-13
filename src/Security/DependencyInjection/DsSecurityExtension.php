<?php

namespace Ds\Component\Security\DependencyInjection;

use Ds\Component\Security\EventListener\Token;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader;

/**
 * Class DsSecurityExtension
 *
 * @package Ds\Component\Security
 */
final class DsSecurityExtension extends Extension implements PrependExtensionInterface
{
    /**
     * {@inheritdoc}
     */
    public function prepend(ContainerBuilder $container)
    {
        $container->prependExtensionConfig('ds_security', [
            'token' => [
                'uuid' => false,
                'ip' => false,
                'client' => false,
                'modifier' => false,
                'identity' => [
                    'roles' => false,
                    'type' => false,
                    'uuid' => false
                ]
            ]
        ]);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('security.yaml');
    }

    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yaml');

        $configuration = new Configuration;
        $config = $this->processConfiguration($configuration, $configs);

        $token = [
            'uuid' => Token\UuidListener::class,
            'ip' => Token\IpListener::class,
            'client' => Token\ClientListener::class,
            'modifier' => Token\ModifierListener::class,
            'identity.roles' => Token\Identity\RolesListener::class,
            'identity.type' => Token\Identity\TypeListener::class,
            'identity.uuid' => Token\Identity\UuidListener::class
        ];

        foreach ($config['token'] as $property => $enabled) {
            if (!$enabled) {
                $container->removeDefinition($token[$property]);
            }
        }
    }
}
