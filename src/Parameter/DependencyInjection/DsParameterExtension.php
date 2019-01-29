<?php

namespace Ds\Component\Parameter\DependencyInjection;

use Ds\Component\Parameter\Collection\ParameterCollection;
use LogicException;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * Class DsParameterExtension
 *
 * @package Ds\Component\Parameter
 */
final class DsParameterExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration;
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yaml');

        $elements = [];

        foreach ($config['parameters'] as $element) {
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

        $definition = $container->findDefinition(ParameterCollection::class);
        $definition->setArguments([$elements]);
    }
}
