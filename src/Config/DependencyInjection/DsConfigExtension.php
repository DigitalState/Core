<?php

namespace Ds\Component\Config\DependencyInjection;

use Ds\Component\Config\Collection\ConfigCollection;
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
final class DsConfigExtension extends Extension implements PrependExtensionInterface
{
    /**
     * {@inheritdoc}
     */
    public function prepend(ContainerBuilder $container)
    {
        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('config.yaml');
    }

    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration;
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('api_filters.yaml');
        $loader->load('services.yaml');

        $elements = [];

        foreach ($config['configs'] as $element) {
            if (!array_key_exists('key', $element)) {
                throw new LogicException('Config key is missing.');
            }

            if (!array_key_exists('encrypt', $element)) {
                $element['encrypt'] = false;
            }

            if (!array_key_exists('title', $element)) {
                $element['title'] = null;
            }

            $elements[$element['key']] = $element;
        }

        $definition = $container->findDefinition(ConfigCollection::class);
        $definition->setArguments([$elements]);
    }
}
