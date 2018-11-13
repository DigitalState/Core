<?php

namespace Ds\Component\Acl\DependencyInjection;

use Ds\Component\Acl\Collection\EntityCollection;
use Ds\Component\Acl\Collection\PermissionCollection;
use Ds\Component\Acl\Doctrine\ORM\QueryExtension\EntityExtension;
use Ds\Component\Acl\EventListener\EntityListener;
use Ds\Component\Acl\Model\Permission;
use Ds\Component\Acl\Serializer\Normalizer\Property\JsonLdNormalizer;
use Ds\Component\Acl\Serializer\Normalizer\Property\JsonNormalizer;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader;

/**
 * Class DsAclExtension
 *
 * @package Ds\Component\Acl
 */
final class DsAclExtension extends Extension implements PrependExtensionInterface
{
    /**
     * {@inheritdoc}
     */
    public function prepend(ContainerBuilder $container)
    {
        $container->prependExtensionConfig('ds_acl', [
            'enabled' => true,
            'entities' => [],
            'permissions' => []
        ]);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('config.yaml');
    }

    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('api_filters.yaml');
        $loader->load('services.yaml');

        $configuration = new Configuration;
        $config = $this->processConfiguration($configuration, $configs);

        $definition = $container->getDefinition(EntityCollection::class);
        $definition->addArgument($config['entities']);

        foreach ($config['permissions'] as $key => $element) {
            $element['key'] = $key;

            if (!array_key_exists('attributes', $element)) {
                $element['attributes'] = [];
            }

            if (!array_key_exists('type', $element)) {
                $element['type'] = null;
            }

            if (!array_key_exists('value', $element)) {
                $element['value'] = null;
            }

            if (!array_key_exists('title', $element)) {
                $element['title'] = null;
            }

            foreach ([Permission::GENERIC, Permission::ENTITY, Permission::PROPERTY] as $type) {
                if (array_key_exists($type, $element)) {
                    $element['type'] = $type;
                    $element['value'] = $element[$type];
                    unset($element[$type]);
                }
            }

            $config['permissions'][$key] = $element;
        }

        $definition = $container->findDefinition(PermissionCollection::class);
        $definition->setArguments([$config['permissions']]);

        if (!$config['enabled']) {
            $container->removeDefinition(EntityExtension::class);
            $container->removeDefinition(EntityListener::class);
            $container->removeDefinition(JsonNormalizer::class);
            $container->removeDefinition(JsonLdNormalizer::class);
        }
    }
}
