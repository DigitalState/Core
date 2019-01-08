<?php

namespace Ds\Component\System\Api;

use Ds\Component\Discovery\Repository\ServiceRepository;
use Ds\Component\Parameter\Service\ParameterService;
use Ds\Component\System\Collection\ServiceCollection;
use Ds\Component\System\Service\Service;
use OutOfRangeException;

/**
 * Class Api
 *
 * @package Ds\Component\System
 */
final class Api
{
    /**
     * @var \Ds\Component\System\Collection\ServiceCollection
     */
    private $serviceCollection;

    /**
     * @var \Ds\Component\Discovery\Repository\ServiceRepository
     */
    private $serviceRepository;

    /**
     * @var \Ds\Component\Parameter\Service\ParameterService
     */
    private $parameterService;

    /**
     * @var string
     */
    private $namespace;

    /**
     * @var string
     */
    private $environment;

    /**
     * Constructor
     *
     * @param \Ds\Component\System\Collection\ServiceCollection $serviceCollection
     * @param \Ds\Component\Discovery\Repository\ServiceRepository $serviceRepository
     * @param \Ds\Component\Parameter\Service\ParameterService $parameterService
     * @param string $namespace
     * @param string $environment
     */
    public function __construct(ServiceCollection $serviceCollection, ServiceRepository $serviceRepository, ParameterService $parameterService, string $namespace = 'ds', string $environment = 'prod')
    {
        $this->serviceCollection = $serviceCollection;
        $this->serviceRepository = $serviceRepository;
        $this->parameterService = $parameterService;
        $this->namespace = $namespace;
        $this->environment = $environment;
    }

    /**
     * Get service
     *
     * @param string $alias
     * @return \Ds\Component\System\Service\Service
     * @throws \OutOfRangeException
     */
    public function get(string $alias): Service
    {
        if (!$this->serviceCollection->containsKey($alias)) {
            throw new OutOfRangeException('Service "'.$alias.'" does not exist.');
        }

        $service = $this->serviceCollection->get($alias);
        $entry = $this->serviceRepository->find($this->namespace.'_'.explode('.', $alias)[0].'_api_http');

        if ($entry) {
            foreach ($entry->getTags() as $tag) {
                if (substr($tag, 0, 25) === 'proxy.frontend.rule=Host:') {
                    $host = substr($tag, 25);
                    $service->setHost($host);
                }
            }
        }

        $username = $this->parameterService->get('ds_system.user.username');
        $password = $this->parameterService->get('ds_system.user.password');
        $credentials = 'Basic '.base64_encode($username.':'.$password);
        $service->setHeader('Authorization', $credentials);

        return $service;
    }
}
