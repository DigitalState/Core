<?php

namespace Ds\Component\Api\Api;

use Ds\Component\Api\Service;
use GuzzleHttp\ClientInterface;

/**
 * Class Identities
 *
 * @package Ds\Component\Api
 */
class Identities
{
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
     * @var \Ds\Component\Api\Service\IndividualPersonaService
     */
    public $individualPersona;

    /**
     * Constructor
     *
     * @param \GuzzleHttp\ClientInterface $client
     * @param string $host
     * @param array $authorization
     */
    public function __construct(ClientInterface $client, $host = null, array $authorization = [])
    {
        $this->health = new Service\HealthService($client, $host, $authorization);
        $this->config = new Service\ConfigService($client, $host, $authorization);
        $this->access = new Service\AccessService($client, $host, $authorization);
        $this->permission = new Service\PermissionService($client, $host, $authorization);
        $this->individualPersona = new Service\IndividualPersonaService($client, $host, $authorization);
    }

    /**
     * Set host
     *
     * @param string $host
     * @return \Ds\Component\Api\Api\Identities
     */
    public function setHost($host = null)
    {
        $this->health->setHost($host);
        $this->config->setHost($host);
        $this->access->setHost($host);
        $this->permission->setHost($host);
        $this->individualPersona->setHost($host);

        return $this;
    }

    /**
     * Set authorization
     *
     * @param array $authorization
     * @return \Ds\Component\Api\Api\Identities
     */
    public function setAuthorization(array $authorization = [])
    {
        $this->health->setAuthorization($authorization);
        $this->config->setAuthorization($authorization);
        $this->access->setAuthorization($authorization);
        $this->permission->setAuthorization($authorization);
        $this->individualPersona->setAuthorization($authorization);

        return $this;
    }
}
