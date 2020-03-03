<?php

namespace Ds\Component\Discovery\Repository\Adapter\Env;

use Ds\Component\Discovery\Model\Service;

/**
 * Class ServiceRepository
 *
 * @package Ds\Component\Discovery
 */
final class ServiceRepository extends Repository
{
    /**
     * @var array
     */
    private $services;

    /**
     * Constructor
     *
     * @param string $services
     */
    public function __construct(string $services)
    {
        if ($services) {
            $this->services = json_decode(str_replace("'", '"', $services), true);
        } else {
            $this->services = [];
        }
    }

    /**
     * {@inheritdoc}
     */
    public function find($id)
    {
        if (!array_key_exists($id, $this->services)) {
            return null;
        }

        if ('' === $this->services[$id]) {
            return null;
        }

        $model = $this->toModel($this->services[$id]);

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
     * Type cast service string to model
     *
     * @param string $service
     * @return \Ds\Component\Discovery\Model\Service
     */
    protected function toModel(string $service)
    {
        $class = $this->getClassName();
        $model = new $class;
        $model->setHost($service);

        return $model;
    }
}
