<?php

namespace Ds\Component\Discovery\Repository;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\ObjectRepository;
use Ds\Component\Discovery\Model\Config;
use GuzzleHttp\ClientInterface;
use stdClass;

/**
 * Class ConfigRepository
 *
 * @package Ds\Component\Discovery
 */
class ConfigRepository implements ObjectRepository
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

    /**
     * {@inheritdoc}
     */
    public function find($id)
    {
        $response = $this->client->request('GET', 'http://'.$this->host.'/v1/kv/'.$this->namespace.'/'.$id, [
            'headers' => [
                'X-Consul-Token' => $this->token
            ]
        ]);
        $body = (string) $response->getBody();
        $objects = \GuzzleHttp\json_decode($body);

        if (!$objects) {
            return null;
        }

        $model = $this->toModel($objects[0]);

        return $model;
    }

    /**
     * {@inheritdoc}
     */
    public function findAll()
    {

    }

    /**
     * {@inheritdoc}
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        $uri = 'http://'.$this->host.'/v1/kv/'.$this->namespace;

        if (array_key_exists('directory', $criteria)) {
            $uri .= '/'.$criteria['directory'];
            unset($criteria['directory']);
        }

        $response = $this->client->request('GET', $uri, [
            'headers' => [
                'X-Consul-Token' => $this->token
            ],
            'query' => $criteria
        ]);
        $body = (string) $response->getBody();
        $objects = \GuzzleHttp\json_decode($body);
        $models = new ArrayCollection;

        foreach ($objects as $object) {
            $models->add($this->toModel($object));
        }

        return $models;
    }

    /**
     * {@inheritdoc}
     */
    public function findOneBy(array $criteria)
    {

    }

    /**
     * {@inheritdoc}
     */
    public function getClassName()
    {
        return Config::class;
    }

    /**
     * Type cast object to model
     *
     * @param \stdClass $object
     * @return \Ds\Component\Discovery\Model\Config
     */
    protected function toModel(stdClass $object)
    {
        $class = $this->getClassName();
        $model = new $class;
        $model
            ->setKey($object->Key)
            ->setValue(base64_decode($object->Value));

        return $model;
    }
}
