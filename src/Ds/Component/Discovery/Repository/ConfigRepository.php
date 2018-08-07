<?php

namespace Ds\Component\Discovery\Repository;

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
    protected $credential;

    /**
     * Constructor
     *
     * @param \GuzzleHttp\ClientInterface $client
     * @param string $host
     * @param string $credential
     */
    public function __construct(ClientInterface $client, $host, $credential)
    {
        $this->client = $client;
        $this->host = $host;
        $this->credential = $credential;
    }

    /**
     * {@inheritdoc}
     */
    public function find($id)
    {
        $response = $this->client->request('GET', 'http://'.$this->host.'/v1/kv/'.$id, [
            'headers' => [
                'X-Consul-Token' => $this->credential
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
