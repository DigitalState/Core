<?php

namespace Ds\Component\Config\Twig\Extension;

use Ds\Component\Config\Service\ConfigService;
use Twig_Extension;
use Twig_SimpleFunction;

/**
 * Class ConfigExtension
 *
 * @package Ds\Component\Config
 */
final class ConfigExtension extends Twig_Extension
{
    /**
     * @var \Ds\Component\Config\Service\ConfigService
     */
    private $configService;

    /**
     * Constructor
     *
     * @param \Ds\Component\Config\Service\ConfigService $configService
     */
    public function __construct(ConfigService $configService)
    {
        $this->configService = $configService;
    }

    /**
     * Get functions
     *
     * @return array
     */
    public function getFunctions()
    {
        return [
            new Twig_SimpleFunction('ds_config', [$this, 'get'])
        ];
    }

    /**
     * Get config value
     *
     * @param string $name
     * @return mixed
     */
    public function get($name)
    {
        return $this->configService->get($name);
    }
}
