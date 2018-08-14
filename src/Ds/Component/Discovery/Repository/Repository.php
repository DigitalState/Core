<?php

namespace Ds\Component\Discovery\Repository;

use Doctrine\Common\Persistence\ObjectRepository;
use GuzzleHttp\ClientInterface;

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
     * @param \GuzzleHttp\ClientInterface $client
     * @param string $host
     * @param string $token
     * @param string $namespace
     */
    public function __construct(ClientInterface $client, $host, $token, $namespace = 'ds')
    {
        $this->client = $client;
        $this->host = $host;
        $this->token = $token;
        $this->namespace = $namespace;
    }
}
