<?php

namespace Ds\Component\Entity\DependencyInjection;

use Ds\Component\Entity\EventListener;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\DependencyInjection\Extension\Extension;

/**
 * Class DsEntityExtension
 *
 * @package Ds\Component\Entity
 */
final class DsEntityExtension extends Extension implements PrependExtensionInterface
{
    /**
     * {@inheritdoc}
     */
    public function prepend(ContainerBuilder $container)
    {
        $container->prependExtensionConfig('ds_entity', [
            'uuidentifiable' => false,
            'custom_identifiable' => false
        ]);
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

        $definitions = [
            'uuidentifiable' => EventListener\UuidentifiableListener::class,
            'custom_identifiable' => EventListener\CustomIdentifiableListener::class
        ];

        foreach ($config as $behavior => $enabled) {
            if (!$enabled) {
                $container->removeDefinition($definitions[$behavior]);
            }
        }
    }
}
