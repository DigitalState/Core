<?php

namespace Ds\Component\Entity\Bridge\Symfony\Bundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * Class DsEntityExtension
 */
class DsEntityExtension extends Extension implements PrependExtensionInterface
{
    /**
     * {@inheritdoc}
     */
    public function prepend(ContainerBuilder $container)
    {
        $container->prependExtensionConfig('ds_entity', [
            'behavior' => [
                'identitiable' => false,
                'uuidentifiable' => false
            ]
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('parameters.yml');
        $loader->load('event_listeners.yml');
        $loader->load('services.yml');

        $configuration = new Configuration;
        $config = $this->processConfiguration($configuration, $configs);

        $this->loadBehavior($config['behavior'] ?? [], $container);
    }

    /**
     * Load behavior config
     *
     * @param array $config
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     */
    protected function loadBehavior(array $config, ContainerBuilder $container)
    {
        foreach ($config as $behavior => $enabled) {
            if (!$enabled) {
                $container->removeDefinition(sprintf('ds_entity.event_listener.%s', $behavior));
            }
        }
    }
}
