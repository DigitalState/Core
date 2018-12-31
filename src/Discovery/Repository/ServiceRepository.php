<?php

namespace Ds\Component\Discovery\Repository;

use Doctrine\Common\Collections\ArrayCollection;
use Ds\Component\Discovery\Model\Service;
use GuzzleHttp\Exception\ClientException;
use stdClass;

/**
 * Class ServiceRepository
 *
 * @package Ds\Component\Discovery
 */
final class ServiceRepository extends Repository
{
    /**
     * {@inheritdoc}
     */
    public function find($id)
    {
        try {
            $response = $this->client->request('GET', 'http://'.$this->host.'/v1/catalog/service/'.$id, [
                'headers' => [
                    'X-Consul-Token' => $this->token
                ]
            ]);
        } catch (ClientException $exception) {
            return null;
        }

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
        $response = $this->client->request('GET', 'http://'.$this->host.'/v1/catalog/services', [
            'headers' => [
                'X-Consul-Token' => $this->token
            ]
        ]);
        $body = (string) $response->getBody();
        $objects = \GuzzleHttp\json_decode($body);
        $models = new ArrayCollection;

        if ($objects) {
            foreach ($objects as $id => $tags) {
                if (array_key_exists('id', $criteria) && !preg_match($criteria['id'], $id)) {
                    continue;
                }

                if (array_key_exists('tag', $criteria) && !in_array($criteria['tag'], $tags)) {
                    continue;
                }

                $response = $this->client->request('GET', 'http://'.$this->host.'/v1/catalog/service/'.$id, [
                    'headers' => [
                        'X-Consul-Token' => $this->token
                    ]
                ]);
                $body = (string) $response->getBody();
                $objects = \GuzzleHttp\json_decode($body);

                if (!$objects) {
                    continue;
                }

                $models->add($this->toModel($objects[0]));
            }
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
            ->setId($object->ServiceID)
            ->setIp($object->ServiceAddress)
            ->setPort($object->ServicePort)
            ->setMeta((array) $object->ServiceMeta)
            ->setTags($object->ServiceTags);

        return $model;
    }
}
