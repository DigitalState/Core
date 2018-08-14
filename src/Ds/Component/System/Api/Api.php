<?php

namespace Ds\Component\System\Api;

use Ds\Component\System\Collection\ServiceCollection;
use Ds\Component\Config\Service\ParameterService;
use Ds\Component\Discovery\Repository\ServiceRepository;
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
     * @var \Ds\Component\Discovery\Repository\ServiceRepository
     */
    protected $serviceRepository;

    /**
     * @var \Ds\Component\Config\Service\ParameterService
     */
    protected $parameterService;

    /**
     * Constructor
     *
     * @param \Ds\Component\System\Collection\ServiceCollection $serviceCollection
     * @param \Ds\Component\Discovery\Repository\ServiceRepository $serviceRepository
     * @param \Ds\Component\Config\Service\ParameterService $parameterService
     */
    public function __construct(ServiceCollection $serviceCollection, ServiceRepository $serviceRepository, ParameterService $parameterService)
    {
        $this->serviceCollection = $serviceCollection;
        $this->serviceRepository = $serviceRepository;
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
        $discovered = $this->serviceRepository->find(explode('.', $alias)[0].'_api_80');
        $service->setHost($discovered->getIp().':'.$discovered->getPort());
        $username = $this->parameterService->get('ds_system.user.username');
        $password = $this->parameterService->get('ds_system.user.password');
        $credentials = 'Basic '.base64_encode($username.':'.$password);
        $service->setHeader('Authorization', $credentials);

        return $service;
    }
}
