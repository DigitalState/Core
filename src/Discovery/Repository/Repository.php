<?php

namespace Ds\Component\Discovery\Repository;

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
     * Constructor
     *
     * @param string $host
     * @param string $token
     */
    public function __construct(string $host = null, string $token = null)
    {
        $this->client = new Client;
        $this->host = $host;
        $this->token = $token;
    }
}
