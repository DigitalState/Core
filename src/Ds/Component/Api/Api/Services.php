<?php

namespace Ds\Component\Api\Api;

use Ds\Component\Api\Service;
use GuzzleHttp\ClientInterface;

/**
 * Class Services
 *
 * @package Ds\Component\Api
 */
class Services
{
    /**
     * @const string
     */
    const HOST = 'api.services.ds';

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
     * @param array $headers
     */
    public function __construct(ClientInterface $client, $host = null, array $headers = [])
    {
        if (!array_key_exists('Host', $headers)) {
            $headers['Host'] = static::HOST;
        }

        $this->health = new Service\HealthService($client, $host, $headers);
        $this->config = new Service\ConfigService($client, $host, $headers);
        $this->access = new Service\AccessService($client, $host, $headers);
        $this->permission = new Service\PermissionService($client, $host, $headers);
    }

    /**
     * Set host
     *
     * @param string $host
     * @return \Ds\Component\Api\Api\Services
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
     * Set headers
     *
     * @param array $headers
     * @return \Ds\Component\Api\Api\Services
     */
    public function setHeaders(array $headers = [])
    {
        $this->health->setHeaders($headers);
        $this->config->setHeaders($headers);
        $this->access->setHeaders($headers);
        $this->permission->setHeaders($headers);

        return $this;
    }
}
