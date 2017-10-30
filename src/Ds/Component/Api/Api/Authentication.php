<?php

namespace Ds\Component\Api\Api;

use Ds\Component\Api\Service;
use GuzzleHttp\ClientInterface;

/**
 * Class Authentication
 *
 * @package Ds\Component\Api
 */
class Authentication
{
    /**
     * @const string
     */
    const HOST = 'api.authentication.ds';

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
     * @var \Ds\Component\Api\Service\UserService
     */
    public $user;

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
        $this->user = new Service\UserService($client, $host, $headers);
    }

    /**
     * Set host
     *
     * @param string $host
     * @return \Ds\Component\Api\Api\Authentication
     */
    public function setHost($host = null)
    {
        $this->health->setHost($host);
        $this->config->setHost($host);
        $this->access->setHost($host);
        $this->permission->setHost($host);
        $this->user->setHost($host);

        return $this;
    }

    /**
     * Set headers
     *
     * @param array $headers
     * @return \Ds\Component\Api\Api\Authentication
     */
    public function setHeaders(array $headers = [])
    {
        $this->health->setHeaders($headers);
        $this->config->setHeaders($headers);
        $this->access->setHeaders($headers);
        $this->permission->setHeaders($headers);
        $this->user->setHeaders($headers);

        return $this;
    }
}
