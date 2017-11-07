<?php

namespace Ds\Component\Api\Api;

use Ds\Component\Api\Collection\ServiceCollection;
use Ds\Component\Config\Service\ConfigService;
use Ds\Component\Security\User\User;
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
     * @param \Ds\Component\Config\Service\ConfigService $configService
     * @param \Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface $tokenManager
     */
    public function __construct(ServiceCollection $serviceCollection, ConfigService $configService, JWTTokenManagerInterface $tokenManager)
    {
        $this->serviceCollection = $serviceCollection;
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
        $service->setHost($this->configService->get('ds_api.api.'.explode('.', $alias)[0].'.host'));
        $service->setHeader('Authorization', 'Bearer '.$this->getToken());

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
            $uuid = $this->configService->get('ds_api.user.uuid');
            $roles = ['ROLE_USER', $this->configService->get('ds_api.user.roles')]; // @todo Allow configs to be arrays (which will also allow to remove the hard coded ROLE_USER)
            $identity = $this->configService->get('ds_api.user.identity');
            $identityUuid = $this->configService->get('ds_api.user.identity_uuid');
            $user = User::createFromPayload($username, compact('uuid', 'roles', 'identity', 'identityUuid'));
            $this->token = $this->tokenManager->create($user);
        }

        return $this->token;
    }
}
