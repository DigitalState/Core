<?php

namespace Ds\Component\Discovery\Repository;

use Ds\Component\Discovery\Model\Service;

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
        return $this->adapterCollection->get($this->adapter.'_service')->find($id);
    }

    /**
     * {@inheritdoc}
     */
    public function findAll()
    {
        return $this->adapterCollection->get($this->adapter.'_service')->findAll();
    }

    /**
     * {@inheritdoc}
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        return $this->adapterCollection->get($this->adapter.'_service')->findBy($criteria, $orderBy, $limit, $offset);
    }

    /**
     * {@inheritdoc}
     */
    public function findOneBy(array $criteria)
    {
        return $this->adapterCollection->get($this->adapter.'_service')->findOneBy($criteria);
    }

    /**
     * {@inheritdoc}
     */
    public function getClassName()
    {
        return Service::class;
    }
}
