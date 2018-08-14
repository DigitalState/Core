<?php

namespace Ds\Component\Discovery\Repository;

use Ds\Component\Discovery\Model\Service;
use stdClass;

/**
 * Class ServiceRepository
 *
 * @package Ds\Component\Discovery
 */
class ServiceRepository extends Repository
{
    /**
     * {@inheritdoc}
     */
    public function find($id)
    {
        $response = $this->client->request('GET', 'http://'.$this->host.'/v1/catalog/service/'.$this->namespace.$id, [
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
        return Service::class;
    }

    /**
     * Type cast object to model
     *
     * @param \stdClass $object
     * @return \Ds\Component\Discovery\Model\Service
     */
    protected function toModel(stdClass $object)
    {
        $class = $this->getClassName();
        $model = new $class;
        $model
            ->setId($object->ID)
            ->setIp($object->ServiceAddress)
            ->setPort($object->ServicePort);

        return $model;
    }
}
