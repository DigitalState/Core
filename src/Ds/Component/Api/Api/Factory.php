<?php

namespace Ds\Component\Api\Api;

use Ds\Component\Config\Service\ConfigService;

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
     * Constructor
     *
     * @param \Ds\Component\Api\Api\Api $api
     * @param \Ds\Component\Config\Service\ConfigService $configService
     */
    public function __construct(Api $api, ConfigService $configService)
    {
        $this->api = $api;
        $this->configService = $configService;
    }

    /**
     * Create api instance
     *
     * @return \Ds\Component\Api\Api\Api
     */
    public function create()
    {
        $api = clone $this->api;
        $api->authentication->setHost($this->configService->get('ds_api.host.authentication'));
        $api->identities->setHost($this->configService->get('ds_api.host.identities'));
        $api->cases->setHost($this->configService->get('ds_api.host.cases'));
        $api->services->setHost($this->configService->get('ds_api.host.services'));
        $api->records->setHost($this->configService->get('ds_api.host.records'));
        $api->assets->setHost($this->configService->get('ds_api.host.assets'));
        $api->cms->setHost($this->configService->get('ds_api.host.cms'));
        $api->camunda->setHost($this->configService->get('ds_api.host.camunda'));
        $api->formio->setHost($this->configService->get('ds_api.host.formio'));

        return $api;
    }
}
