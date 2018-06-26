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
    const CACHE_DATA = 'ds_discovery.cache.data';

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
     * Get discovery data
     *
     * @param string $service
     * @return \stdClass
     * @throws \DomainException
     */
    public function get($service = null)
    {
        $data = null;

        if ($this->cache) {
            $item = $this->cache->getItem(static::CACHE_DATA);

            if ($item->isHit()) {
                $data = $item->get();
            } else {
                $data = $this->getData();
                $item->set($data);
                $this->cache->save($item);
            }
        } else {
            $data = $this->getData();
        }

        if (null === $service) {
            return $data;
        }

        if (!array_key_exists($service, $data)) {
            throw new DomainException('Service does not exist.');
        }

        return $data[$service];
    }

    /**
     * Get data
     *
     * @return array
     */
    protected function getData()
    {
        $response = $this->client->request('GET', 'http://'.$this->host.'/data.json');
        $body = (string) $response->getBody();
        $data = \GuzzleHttp\json_decode($body);

        return $data;
    }
}
