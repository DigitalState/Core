<?php

namespace Ds\Component\Api\Api\Services;

use GuzzleHttp\ClientInterface;
use Ds\Component\Api\Service\Services;

/**
 * Class Api
 */
class Api
{
    /**
     * @var \Ds\Component\Api\Service\Services\ServiceService
     */
    public $service;

    /**
     * Constructor
     *
     * @param \GuzzleHttp\ClientInterface $client
     * @param string $host
     */
    public function __construct(ClientInterface $client, $host = null)
    {
        $this->service = new Services\ServiceService($client, $host);
    }

    /**
     * Set host
     *
     * @param string $host
     * @return \Ds\Component\Api\Api\Services\Api
     */
    public function setHost($host)
    {
        $this->service->setHost($host);

        return $this;
    }
}
