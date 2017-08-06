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
     * @var \Ds\Component\Api\Api\Assets\Api
     */
    public $assets;

    /**
     * @var \Ds\Component\Api\Api\Authentication\Api
     */
    public $authentication;

    /**
     * @var \Ds\Component\Api\Api\Cms\Api
     */
    public $cms;

    /**
     * @var \Ds\Component\Api\Api\Identities\Api
     */
    public $identities;

    /**
     * @var \Ds\Component\Api\Api\Records\Api
     */
    public $records;

    /**
     * @var \Ds\Component\Api\Api\Services\Api
     */
    public $services;

    /**
     * Constructor
     *
     * @param \GuzzleHttp\ClientInterface $client
     * @param string $host
     */
    public function __construct(ClientInterface $client, $host = null)
    {
        $this->assets = new Assets\Api($client, $host);
        $this->authentication = new Authentication\Api($client, $host);
        $this->cms = new Cms\Api($client, $host);
        $this->identities = new Identities\Api($client, $host);
        $this->records = new Records\Api($client, $host);
        $this->services = new Services\Api($client, $host);
    }

    /**
     * Set host
     *
     * @param string $host
     * @return \Ds\Component\Api\Api\Api
     */
    public function setHost($host)
    {
        $this->assets->setHost($host);
        $this->authentication->setHost($host);
        $this->cms->setHost($host);
        $this->identities->setHost($host);
        $this->records->setHost($host);
        $this->services->setHost($host);

        return $this;
    }
}
