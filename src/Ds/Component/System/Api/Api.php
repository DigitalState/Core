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
     * @var string
     */
    protected $namespace;

    /**
     * @var \Ds\Component\Config\Service\ParameterService
     */
    protected $parameterService;

    /**
     * Constructor
     *
     * @param \Ds\Component\System\Collection\ServiceCollection $serviceCollection
     * @param \Ds\Component\Discovery\Repository\ServiceRepository $serviceRepository
     * @param string $namespace
     * @param \Ds\Component\Config\Service\ParameterService $parameterService
     */
    public function __construct(ServiceCollection $serviceCollection, ServiceRepository $serviceRepository, $namespace = 'ds', ParameterService $parameterService)
    {
        $this->serviceCollection = $serviceCollection;
        $this->serviceRepository = $serviceRepository;
        $this->namespace = $namespace;
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
        $discovered = $this->serviceRepository->find($this->namespace.explode('.', $alias)[0].'_api_http');

        if ($discovered) {
            foreach ($discovered->getTags() as $tag) {
                if (substr($tag, 0, 25) === 'proxy.frontend.rule=Host:') {
                    $host = substr($tag, 25);
                    $service->setHost($host.':'.$discovered->getPort());
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
