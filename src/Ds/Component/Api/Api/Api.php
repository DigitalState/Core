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
     * @var \Ds\Component\Api\Api\Identities\Api
     */
    public $identities;

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
        $this->identities = new Identities\Api($client, $host);
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
        $this->identities->setHost($host);
        $this->services->setHost($host);

        return $this;
    }
}
