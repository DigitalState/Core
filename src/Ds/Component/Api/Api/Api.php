<?php

namespace Ds\Component\Api\Api;

use Ds\Component\Camunda\Api\Api as Camunda;
use Ds\Component\Formio\Api\Api as Formio;
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
     */
    public function __construct(ClientInterface $client, $host = null)
    {
        $this->authentication = new Authentication($client, $host);
        $this->identities = new Identities($client, $host);
        $this->cases = new Cases($client, $host);
        $this->services = new Services($client, $host);
        $this->records = new Records($client, $host);
        $this->assets = new Assets($client, $host);
        $this->cms = new Cms($client, $host);
        $this->camunda = new Camunda($client, $host);
        $this->formio = new Formio($client, $host);
    }

    /**
     * Set host
     *
     * @param string $host
     * @return \Ds\Component\Api\Api\Api
     */
    public function setHost($host)
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
}
