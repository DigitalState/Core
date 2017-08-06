<?php

namespace Ds\Component\Api\Api\Authentication;

use Ds\Component\Api\Service\Authentication;
use GuzzleHttp\ClientInterface;

/**
 * Class Api
 *
 * @package Ds\Component\Api
 */
class Api
{
    /**
     * @var \Ds\Component\Api\Service\Authentication\UserService
     */
    public $user;

    /**
     * Constructor
     *
     * @param \GuzzleHttp\ClientInterface $client
     * @param string $host
     */
    public function __construct(ClientInterface $client, $host = null)
    {
        $this->user = new Authentication\UserService($client, $host);
    }

    /**
     * Set host
     *
     * @param string $host
     * @return \Ds\Component\Api\Api\Authentication\Api
     */
    public function setHost($host)
    {
        $this->user->setHost($host);

        return $this;
    }
}
