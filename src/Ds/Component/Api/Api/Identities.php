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
    const HOST = 'api.identities.ds';

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
     * @var \Ds\Component\Api\Service\OrganizationService
     */
    public $organization;

    /**
     * @var \Ds\Component\Api\Service\OrganizationPersonaService
     */
    public $organizationPersona;

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
        $this->anonymous = new Service\AnonymousService($client, $host, $headers);
        $this->anonymousPersona = new Service\AnonymousPersonaService($client, $host, $headers);
        $this->individual = new Service\IndividualService($client, $host, $headers);
        $this->individualPersona = new Service\IndividualPersonaService($client, $host, $headers);
        $this->organization = new Service\OrganizationService($client, $host, $headers);
        $this->organizationPersona = new Service\OrganizationPersonaService($client, $host, $headers);
        $this->staff = new Service\StaffService($client, $host, $headers);
        $this->staffPersona = new Service\StaffPersonaService($client, $host, $headers);
        $this->system = new Service\SystemService($client, $host, $headers);
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
        $this->organization->setHost($host);
        $this->organizationPersona->setHost($host);
        $this->staff->setHost($host);
        $this->staffPersona->setHost($host);
        $this->system->setHost($host);

        return $this;
    }

    /**
     * Set headers
     *
     * @param array $headers
     * @return \Ds\Component\Api\Api\Identities
     */
    public function setHeaders(array $headers = [])
    {
        $this->health->setHeaders($headers);
        $this->config->setHeaders($headers);
        $this->access->setHeaders($headers);
        $this->permission->setHeaders($headers);
        $this->anonymous->setHeaders($headers);
        $this->anonymousPersona->setHeaders($headers);
        $this->individual->setHeaders($headers);
        $this->individualPersona->setHeaders($headers);
        $this->organization->setHeaders($headers);
        $this->organizationPersona->setHeaders($headers);
        $this->staff->setHeaders($headers);
        $this->staffPersona->setHeaders($headers);
        $this->system->setHeaders($headers);

        return $this;
    }
}
