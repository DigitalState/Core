<?php

namespace Ds\Component\Debug\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * Class DsDebugExtension
 *
 * @package Ds\Component\Debug
 */
class DsDebugExtension extends Extension implements PrependExtensionInterface
{
    /**
     * {@inheritdoc}
     */
    public function prepend(ContainerBuilder $container)
    {
        if ($container->getExtensionConfig('dunglas_action')) {
            $container->prependExtensionConfig('dunglas_action', [
                'directories' => [
                    __DIR__.'/../Action'
                ]
            ]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
    }
}
