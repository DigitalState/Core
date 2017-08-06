<?php

namespace Ds\Component\Api\Api\Assets;

use Ds\Component\Api\Service\Assets;
use GuzzleHttp\ClientInterface;

/**
 * Class Api
 *
 * @package Ds\Component\Api
 */
class Api
{
    /**
     * @var \Ds\Component\Api\Service\Assets\AssetService
     */
    public $asset;

    /**
     * Constructor
     *
     * @param \GuzzleHttp\ClientInterface $client
     * @param string $host
     */
    public function __construct(ClientInterface $client, $host = null)
    {
        $this->asset = new Assets\AssetService($client, $host);
    }

    /**
     * Set host
     *
     * @param string $host
     * @return \Ds\Component\Api\Api\Assets\Api
     */
    public function setHost($host)
    {
        $this->asset->setHost($host);

        return $this;
    }
}
