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
     * @const string
     */
    const PROXY = 'api.identities.ds';

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
     * @var \Ds\Component\Api\Service\AnonymousService
     */
    public $anonymous;

    /**
     * @var \Ds\Component\Api\Service\AnonymousPersonaService
     */
    public $anonymousPersona;

    /**
     * @var \Ds\Component\Api\Service\IndividualService
     */
    public $individual;

    /**
     * @var \Ds\Component\Api\Service\IndividualPersonaService
     */
    public $individualPersona;

    /**
     * @var \Ds\Component\Api\Service\StaffService
     */
    public $staff;

    /**
     * @var \Ds\Component\Api\Service\StaffPersonaService
     */
    public $staffPersona;

    /**
     * @var \Ds\Component\Api\Service\SystemService
     */
    public $system;

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
        $this->anonymous = new Service\AnonymousService($client, static::PROXY, $host, $authorization);
        $this->anonymousPersona = new Service\AnonymousPersonaService($client, static::PROXY, $host, $authorization);
        $this->individual = new Service\IndividualService($client, static::PROXY, $host, $authorization);
        $this->individualPersona = new Service\IndividualPersonaService($client, static::PROXY, $host, $authorization);
        $this->staff = new Service\StaffService($client, static::PROXY, $host, $authorization);
        $this->staffPersona = new Service\StaffPersonaService($client, static::PROXY, $host, $authorization);
        $this->system = new Service\SystemService($client, static::PROXY, $host, $authorization);
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
        $this->anonymous->setHost($host);
        $this->anonymousPersona->setHost($host);
        $this->individual->setHost($host);
        $this->individualPersona->setHost($host);
        $this->staff->setHost($host);
        $this->staffPersona->setHost($host);
        $this->system->setHost($host);

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
        $this->anonymous->setAuthorization($authorization);
        $this->anonymousPersona->setAuthorization($authorization);
        $this->individual->setAuthorization($authorization);
        $this->individualPersona->setAuthorization($authorization);
        $this->staff->setAuthorization($authorization);
        $this->staffPersona->setAuthorization($authorization);
        $this->system->setAuthorization($authorization);

        return $this;
    }
}
