<?php

namespace Ds\Component\Discovery\Repository\Adapter\Consul;

use Doctrine\Common\Persistence\ObjectRepository;
use GuzzleHttp\Client;

/**
 * Class Repository
 *
 * @package Ds\Component\Discovery
 */
abstract class Repository implements ObjectRepository
{
    /**
     * @var \GuzzleHttp\ClientInterface
     */
    protected $client;

    /**
     * @var string
     */
    protected $host;

    /**
     * @var string
     */
    protected $token;

    /**
     * @var string
     */
    protected $namespace;

    /**
     * Constructor
     *
     * @param string $host
     * @param string $token
     * @param string $namespace
     */
    public function __construct(string $host = null, string $token = null, string $namespace = null)
    {
        $this->client = new Client;
        $this->host = $host;
        $this->token = $token;
        $this->namespace = $namespace;
    }
}
