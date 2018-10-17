<?php

namespace Ds\Component\Api\Api;

use Ds\Component\Api\Collection\ServiceCollection;
use Ds\Component\Config\Service\ConfigService;
use Ds\Component\Discovery\Repository\ServiceRepository;
use Ds\Component\Security\Model\User;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use OutOfRangeException;

/**
 * Class Api
 *
 * @package Ds\Component\Api
 */
class Api
{
    /**
     * @var \Ds\Component\Api\Collection\ServiceCollection
     */
    protected $serviceCollection;

    /**
     * @var \Ds\Component\Discovery\Repository\ServiceRepository
     */
    protected $serviceRepository;

    /**
     * @var \Ds\Component\Config\Service\ConfigService
     */
    protected $configService;

    /**
     * @var string
     */
    protected $namespace;

    /**
     * @var string
     */
    protected $environment;

    /**
     * @var \Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface
     */
    protected $tokenManager;

    /**
     * @var string
     */
    protected $token;

    /**
     * Constructor
     *
     * @param \Ds\Component\Api\Collection\ServiceCollection $serviceCollection
     * @param \Ds\Component\Discovery\Repository\ServiceRepository $serviceRepository
     * @param \Ds\Component\Config\Service\ConfigService $configService
     * @param string $namespace
     * @param string $environment
     * @param \Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface $tokenManager
     */
    public function __construct(ServiceCollection $serviceCollection, ServiceRepository $serviceRepository, ConfigService $configService, $namespace = 'ds', $environment = 'prod', JWTTokenManagerInterface $tokenManager)
    {
        $this->serviceCollection = $serviceCollection;
        $this->serviceRepository = $serviceRepository;
        $this->configService = $configService;
        $this->namespace = $namespace;
        $this->environment = $environment;
        $this->tokenManager = $tokenManager;
    }

    /**
     * Get service
     *
     * @param string $alias
     * @return \Ds\Component\Api\Service\Service
     * @throws \OutOfRangeException
     */
    public function get($alias)
    {
        if (!$this->serviceCollection->containsKey($alias)) {
            throw new OutOfRangeException('Service does not exist.');
        }

        $service = $this->serviceCollection->get($alias);
        $discovered = $this->serviceRepository->find($this->namespace.explode('.', $alias)[0].'_api_http');

        if ($discovered) {
            foreach ($discovered->getTags() as $tag) {
                if (substr($tag, 0, 25) === 'proxy.frontend.rule=Host:') {
                    $host = substr($tag, 25);
                    $entrypoint = $discovered->getMeta('entrypoint-'.$this->environment);
                    $host = str_replace('${url}', $host, $entrypoint);
                    $service->setHost($host);
                }
            }
        }

        $credentials = 'Bearer '.$this->getToken();
        $service->setHeader('Authorization', $credentials);

        return $service;
    }

    /**
     * Get token
     *
     * @return string
     */
    protected function getToken()
    {
        if (!$this->token) {
            $username = $this->configService->get('ds_api.user.username');
            $payload = [
                'uuid' => $this->configService->get('ds_api.user.uuid'),
                'roles' => $this->configService->get('ds_api.user.roles'),
                'identity' => [
                    'roles' => $this->configService->get('ds_api.user.identity.roles'),
                    'type' => $this->configService->get('ds_api.user.identity.type'),
                    'uuid' => $this->configService->get('ds_api.user.identity.uuid')
                ],
                'tenant' => $this->configService->get('ds_api.user.tenant')
            ];
            $user = User::createFromPayload($username, $payload);
            $this->token = $this->tokenManager->create($user);
        }

        return $this->token;
    }
}
