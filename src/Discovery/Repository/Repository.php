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
     * Constructor
     *
     * @param \GuzzleHttp\ClientInterface $client
     * @param string $host
     * @param string $token
     */
    public function __construct(ClientInterface $client, string $host = null, string $token = null)
    {
        $this->client = $client;
        $this->host = $host;
        $this->token = $token;
    }
}
