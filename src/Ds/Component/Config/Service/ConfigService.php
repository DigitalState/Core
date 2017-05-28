<?php

namespace Ds\Component\Config\Service;

use Ds\Component\Config\Collection\ConfigCollection;
use Ds\Component\Config\Repository\ConfigRepository;
use OutOfRangeException;

/**
 * Class ConfigService
 */
class ConfigService
{
    /**
     * @var \Ds\Component\Config\Collection\ConfigCollection
     */
    protected $configCollection;

    /**
     * @var \Ds\Component\Config\Repository\ConfigRepository
     */
    protected $configRepository;

    /**
     * Constructor
     *
     * @param \Ds\Component\Config\Collection\ConfigCollection $configCollection
     * @param \Ds\Component\Config\Repository\ConfigRepository $configRepository
     */
    public function __construct(ConfigCollection $configCollection, ConfigRepository $configRepository)
    {
        $this->configCollection = $configCollection;
        $this->configRepository = $configRepository;
    }

    /**
     * Get config value
     *
     * @param string $key
     * @return mixed
     * @throws \OutOfRangeException
     */
    public function get($key)
    {
        $config = $this->configRepository->findOneBy(['key' => $key]);

        if (!$config) {
            throw new OutOfRangeException('Config does not exist.');
        }

        if ($config->getFallback()) {
            return $this->configCollection->get($key);
        }

        return $config->getValue();
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
