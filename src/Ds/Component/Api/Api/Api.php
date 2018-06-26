<?php

namespace Ds\Component\Api\Api;

use Ds\Component\Api\Collection\ServiceCollection;
use Ds\Component\Config\Service\ConfigService;
use Ds\Component\Discovery\Service\DiscoveryService;
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
     * @var \Ds\Component\Discovery\Service\DiscoveryService
     */
    protected $discoveryService;

    /**
     * @var \Ds\Component\Config\Service\ConfigService
     */
    protected $configService;

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
     * @param \Ds\Component\Discovery\Service\DiscoveryService $discoveryService
     * @param \Ds\Component\Config\Service\ConfigService $configService
     * @param \Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface $tokenManager
     */
    public function __construct(ServiceCollection $serviceCollection, DiscoveryService $discoveryService, ConfigService $configService, JWTTokenManagerInterface $tokenManager)
    {
        $this->serviceCollection = $serviceCollection;
        $this->discoveryService = $discoveryService;
        $this->configService = $configService;
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
        $host = $this->discoveryService->get(explode('.', $alias)[0])->host;
        $service->setHost($host);
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
