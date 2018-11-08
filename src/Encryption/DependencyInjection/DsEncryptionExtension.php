<?php

namespace Ds\Component\Encryption\DependencyInjection;

use Ds\Component\Encryption\Service\CipherService;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\Config\FileLocator;

/**
 * Class DsEncryptionExtension
 *
 * @package Ds\Component\Encryption
 */
final class DsEncryptionExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yaml');

        $configuration = new Configuration;
        $config = $this->processConfiguration($configuration, $configs);

        $definition = $container->getDefinition(CipherService::class);
        $definition->addArgument($config['encryption']);
    }
}
