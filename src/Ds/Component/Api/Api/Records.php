<?php

namespace Ds\Component\Api\Api;

use Ds\Component\Api\Service;
use GuzzleHttp\ClientInterface;

/**
 * Class Records
 *
 * @package Ds\Component\Api
 */
class Records
{
    /**
     * @const string
     */
    const PROXY = 'api.records.ds';

    /**
     * @var \Ds\Component\Api\Service\HealthService
     */
    public $health;

    /**
     * @var \Ds\Component\Api\Service\ConfigService
     */
    public $config;

    /**
     * @var \Ds\Component\Api\Service\AccessService
     */
    public $access;

    /**
     * @var \Ds\Component\Api\Service\PermissionService
     */
    public $permission;

    /**
     * Constructor
     *
     * @param \GuzzleHttp\ClientInterface $client
     * @param string $host
     * @param array $authorization
     */
    public function __construct(ClientInterface $client, $host = null, array $authorization = [])
    {
        $this->health = new Service\HealthService($client, static::PROXY, $host, $authorization);
        $this->config = new Service\ConfigService($client, static::PROXY, $host, $authorization);
        $this->access = new Service\AccessService($client, static::PROXY, $host, $authorization);
        $this->permission = new Service\PermissionService($client, static::PROXY, $host, $authorization);
    }

    /**
     * Set host
     *
     * @param string $host
     * @return \Ds\Component\Api\Api\Records
     */
    public function setHost($host = null)
    {
        $this->health->setHost($host);
        $this->config->setHost($host);
        $this->access->setHost($host);
        $this->permission->setHost($host);

        return $this;
    }

    /**
     * Set authorization
     *
     * @param array $authorization
     * @return \Ds\Component\Api\Api\Records
     */
    public function setAuthorization(array $authorization = [])
    {
        $this->health->setAuthorization($authorization);
        $this->config->setAuthorization($authorization);
        $this->access->setAuthorization($authorization);
        $this->permission->setAuthorization($authorization);

        return $this;
    }
}
