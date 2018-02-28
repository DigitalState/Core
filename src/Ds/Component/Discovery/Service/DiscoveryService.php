<?php

namespace Ds\Component\Discovery\Service;

use DomainException;
use GuzzleHttp\ClientInterface;
use Symfony\Component\Cache\Adapter\AbstractAdapter;

/**
 * Class DiscoveryService
 *
 * @package Ds\Component\Discovery
 */
class DiscoveryService
{
    /**
     * @const string
     */
    const CACHE_MAP = 'ds_discovery.cache.map';

    /**
     * @var \GuzzleHttp\ClientInterface
     */
    protected $client;

    /**
     * @var string
     */
    protected $host;

    /**
     * @var \Symfony\Component\Cache\Adapter\AbstractAdapter
     */
    protected $cache;

    /**
     * Constructor
     *
     * @param \GuzzleHttp\ClientInterface $client
     * @param string $host
     * @param \Symfony\Component\Cache\Adapter\AbstractAdapter $cache
     */
    public function __construct(ClientInterface $client, $host, AbstractAdapter $cache = null)
    {
        $this->client = $client;
        $this->host = $host;
        $this->cache = $cache;
    }

    /**
     * Get service host
     *
     * @param string $service
     * @return string
     * @throws \DomainException
     */
    public function get($service)
    {
        $map = null;

        if ($this->cache) {
            $item = $this->cache->getItem(static::CACHE_MAP);

            if ($item->isHit()) {
                $map = $item->get();
            } else {
                $map = $this->getMap();
                $item->set($map);
                $this->cache->save($item);
            }
        } else {
            $map = $this->getMap();
        }

        if (!array_key_exists($service, $map)) {
            throw new DomainException('Service does not exist.');
        }

        return $map[$service];
    }

    /**
     * Get map of service endpoints
     *
     * @return array
     */
    protected function getMap()
    {
        $response = $this->client->request('GET', 'http://' . $this->host);
        $body = (string) $response->getBody();
        $map = \GuzzleHttp\json_decode($body, true);

        return $map;
    }
}
