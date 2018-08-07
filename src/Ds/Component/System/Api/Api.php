<?php

namespace Ds\Component\System\Api;

use Ds\Component\System\Collection\ServiceCollection;
use Ds\Component\Config\Service\ParameterService;
use Ds\Component\Discovery\Repository\ConfigRepository;
use OutOfRangeException;

/**
 * Class Api
 *
 * @package Ds\Component\System
 */
class Api
{
    /**
     * @var \Ds\Component\System\Collection\ServiceCollection
     */
    protected $serviceCollection;

    /**
     * @var \Ds\Component\Discovery\Repository\ConfigRepository
     */
    protected $configRepository;

    /**
     * @var \Ds\Component\Config\Service\ParameterService
     */
    protected $parameterService;

    /**
     * Constructor
     *
     * @param \Ds\Component\System\Collection\ServiceCollection $serviceCollection
     * @param \Ds\Component\Discovery\Repository\ConfigRepository $configRepository
     * @param \Ds\Component\Config\Service\ParameterService $parameterService
     */
    public function __construct(ServiceCollection $serviceCollection, ConfigRepository $configRepository, ParameterService $parameterService)
    {
        $this->serviceCollection = $serviceCollection;
        $this->configRepository = $configRepository;
        $this->parameterService = $parameterService;
    }

    /**
     * Get service
     *
     * @param string $alias
     * @return \Ds\Component\System\Service\Service
     * @throws \OutOfRangeException
     */
    public function get($alias)
    {
        if (!$this->serviceCollection->containsKey($alias)) {
            throw new OutOfRangeException('Service "'.$alias.'" does not exist.');
        }

        $service = $this->serviceCollection->get($alias);
        $host = $this->configRepository->find('services/'.explode('.', $alias)[0].'/host')->getValue();
        $service->setHost($host);
        $username = $this->parameterService->get('ds_system.user.username');
        $password = $this->parameterService->get('ds_system.user.password');
        $credentials = 'Basic '.base64_encode($username.':'.$password);
        $service->setHeader('Authorization', $credentials);

        return $service;
    }
}
