<?php

namespace Ds\Component\Discovery\Repository;

use Doctrine\Common\Collections\ArrayCollection;
use Ds\Component\Discovery\Model\Config;
use stdClass;

/**
 * Class ConfigRepository
 *
 * @package Ds\Component\Discovery
 */
class ConfigRepository extends Repository
{
    /**
     * {@inheritdoc}
     */
    public function find($id)
    {
        $response = $this->client->request('GET', 'http://'.$this->host.'/v1/kv/'.$id, [
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
        $uri = 'http://'.$this->host.'/v1/kv/';

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
