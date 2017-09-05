<?php

namespace Ds\Component\Api\Api;

use GuzzleHttp\ClientInterface;

/**
 * Class Api
 *
 * @package Ds\Component\Api
 */
class Api
{
    /**
     * @var \Ds\Component\Api\Api\Authentication
     */
    public $authentication;

    /**
     * @var \Ds\Component\Api\Api\Identities
     */
    public $identities;

    /**
     * @var \Ds\Component\Api\Api\Cases
     */
    public $cases;

    /**
     * @var \Ds\Component\Api\Api\Services
     */
    public $services;

    /**
     * @var \Ds\Component\Api\Api\Records
     */
    public $records;

    /**
     * @var \Ds\Component\Api\Api\Assets
     */
    public $assets;

    /**
     * @var \Ds\Component\Api\Api\Cms
     */
    public $cms;

    /**
     * @var \Ds\Component\Camunda\Api\Api
     */
    public $camunda;

    /**
     * @var \Ds\Component\Formio\Api\Api
     */
    public $formio;

    /**
     * Constructor
     *
     * @param \GuzzleHttp\ClientInterface $client
     * @param string $host
     * @param array $authorization
     */
    public function __construct(ClientInterface $client, $host = null, array $authorization = [])
    {
        $this->authentication = new Authentication($client, $host, $authorization);
        $this->identities = new Identities($client, $host, $authorization);
        $this->cases = new Cases($client, $host, $authorization);
        $this->services = new Services($client, $host, $authorization);
        $this->records = new Records($client, $host, $authorization);
        $this->assets = new Assets($client, $host, $authorization);
        $this->cms = new Cms($client, $host, $authorization);
        $this->camunda = new Camunda($client, $host, $authorization);
        $this->formio = new Formio($client, $host, $authorization);
    }

    /**
     * Set host
     *
     * @param string $host
     * @return \Ds\Component\Api\Api\Api
     */
    public function setHost($host = null)
    {
        $this->authentication->setHost($host);
        $this->identities->setHost($host);
        $this->cases->setHost($host);
        $this->services->setHost($host);
        $this->records->setHost($host);
        $this->assets->setHost($host);
        $this->cms->setHost($host);
        $this->camunda->setHost($host);
        $this->formio->setHost($host);

        return $this;
    }

    /**
     * Set authorization
     *
     * @param array $authorization
     * @return \Ds\Component\Api\Api\Api
     */
    public function setAuthorization(array $authorization = [])
    {
        $this->authentication->setAuthorization($authorization);
        $this->identities->setAuthorization($authorization);
        $this->cases->setAuthorization($authorization);
        $this->services->setAuthorization($authorization);
        $this->records->setAuthorization($authorization);
        $this->assets->setAuthorization($authorization);
        $this->cms->setAuthorization($authorization);
        $this->camunda->setAuthorization($authorization);
        $this->formio->setAuthorization($authorization);

        return $this;
    }
}
