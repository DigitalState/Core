<?php

namespace Ds\Component\Discovery\Repository;

use Ds\Component\Discovery\Model\Config;

/**
 * Class ConfigRepository
 *
 * @package Ds\Component\Discovery
 */
final class ConfigRepository extends Repository
{
    /**
     * {@inheritdoc}
     */
    public function find($id)
    {
        return $this->adapterCollection->get($this->adapter.'_config')->find($id);
    }

    /**
     * {@inheritdoc}
     */
    public function findAll()
    {
        return $this->adapterCollection->get($this->adapter.'_config')->findAll();
    }

    /**
     * {@inheritdoc}
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        return $this->adapterCollection->get($this->adapter.'_config')->findBy($criteria, $orderBy, $limit, $offset);
    }

    /**
     * {@inheritdoc}
     */
    public function findOneBy(array $criteria)
    {
        return $this->adapterCollection->get($this->adapter.'_config')->findOneBy($criteria);
    }

    /**
     * {@inheritdoc}
     */
    public function getClassName()
    {
        return Config::class;
    }
}
