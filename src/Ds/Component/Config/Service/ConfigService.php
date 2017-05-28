<?php

namespace Ds\Component\Config\Service;

use Ds\Component\Config\Repository\ConfigRepository;

/**
 * Class ConfigService
 */
class ConfigService
{
    /**
     * @var \Ds\Component\Config\Repository\ConfigRepository
     */
    protected $configRepository;

    /**
     * Constructor
     *
     * @param \Ds\Component\Config\Repository\ConfigRepository $configRepository
     */
    public function __construct(ConfigRepository $configRepository)
    {
        $this->configRepository = $configRepository;
    }

    /**
     * Get config value
     *
     * @param string $key
     * @return mixed
     */
    public function get($key)
    {

    }

    /**
     * Set config value
     *
     * @param string $key
     * @param mixed $value
     * @param boolean $fallback
     */
    public function set($key, $value, $fallback = null)
    {

    }
}
