<?php

namespace Ds\Component\Api\Api;

use Ds\Component\Config\Service\ConfigService;
use Ds\Component\Security\User\User;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;

/**
 * Class Factory
 *
 * @package Ds\Component\Api
 */
class Factory
{
    /**
     * @var \Ds\Component\Api\Api\Api
     */
    protected $api;

    /**
     * @var \Ds\Component\Config\Service\ConfigService
     */
    protected $configService;

    /**
     * @var \Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface
     */
    protected $tokenManager;

    /**
     * Constructor
     *
     * @param \Ds\Component\Api\Api\Api $api
     * @param \Ds\Component\Config\Service\ConfigService $configService
     * @param \Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface $tokenManager
     */
    public function __construct(Api $api, ConfigService $configService, JWTTokenManagerInterface $tokenManager)
    {
        $this->api = $api;
        $this->configService = $configService;
        $this->tokenManager = $tokenManager;
    }

    /**
     * Create api instance
     *
     * @return \Ds\Component\Api\Api\Api
     */
    public function create()
    {
        $api = clone $this->api;
        $user = User::createFromPayload($this->configService->get('ds_api.credential.username'), [
            'uuid' => $this->configService->get('ds_api.credential.uuid'),
            'roles' => [$this->configService->get('ds_api.credential.roles')],
            'identity' => $this->configService->get('ds_api.credential.identity'),
            'identityUuid' => $this->configService->get('ds_api.credential.identity_uuid')
        ]);
        $token = $this->tokenManager->create($user);
        $api->setAuthorization(['Authorization' => 'Bearer '.$token]);
        $api->authentication->setHost($this->configService->get('ds_api.api.authentication.host'));
        $api->identities->setHost($this->configService->get('ds_api.api.identities.host'));
        $api->cases->setHost($this->configService->get('ds_api.api.cases.host'));
        $api->services->setHost($this->configService->get('ds_api.api.services.host'));
        $api->records->setHost($this->configService->get('ds_api.api.records.host'));
        $api->assets->setHost($this->configService->get('ds_api.api.assets.host'));
        $api->cms->setHost($this->configService->get('ds_api.api.cms.host'));
        $api->camunda->setHost($this->configService->get('ds_api.api.camunda.host'));
        $api->formio->setHost($this->configService->get('ds_api.api.formio.host'));

        return $api;
    }
}
