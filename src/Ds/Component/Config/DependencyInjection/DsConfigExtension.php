<?php

namespace Ds\Component\Config\DependencyInjection;

use LogicException;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * Class DsConfigExtension
 *
 * @package Ds\Component\Config
 */
class DsConfigExtension extends Extension implements PrependExtensionInterface
{
    /**
     * {@inheritdoc}
     */
    public function prepend(ContainerBuilder $container)
    {
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

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('parameters.yml');
        $loader->load('api_filters.yml');
        $loader->load('collections.yml');
        $loader->load('commands.yml');
        $loader->load('event_listeners.yml');
        $loader->load('repositories.yml');
        $loader->load('services.yml');
        $loader->load('tenants.yml');
        $loader->load('twig.yml');

        foreach (['config', 'parameter'] as $type) {
            foreach ($config[$type.'s'] as $key => $element) {
                if (!array_key_exists('key', $element)) {
                    throw new LogicException('Config key is missing.');
                }

                if (!array_key_exists('encrypt', $element)) {
                    $element['encrypt'] = false;
                }

                if (!array_key_exists('title', $element)) {
                    $element['title'] = null;
                }

                $config[$type.'s'][$key] = $element;
            }

            $definition = $container->findDefinition('ds_config.collection.'.$type);
            $definition->setArguments([$config[$type.'s']]);
        }
    }
}
