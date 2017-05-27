<?php

namespace Ds\Component\Model\Bridge\Symfony\Bundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\Config\FileLocator;

/**
 * Class DsModelExtension
 */
class DsModelExtension extends Extension implements PrependExtensionInterface
{
    /**
     * {@inheritdoc}
     */
    public function prepend(ContainerBuilder $container)
    {
        $container->prependExtensionConfig('ds_model', [
            'behavior' => [
                'identitiable' => false,
                'uuidentifiable' => false,
                'translatable' => false,
                'localizable' => false
            ]
        ]);
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
                $container->removeDefinition(sprintf('ds_model.event_listener.%s', $behavior));
            }
        }
    }
}
