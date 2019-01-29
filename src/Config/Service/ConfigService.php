<?php

namespace Ds\Component\Config\Service;

use Doctrine\ORM\EntityManagerInterface;
use Ds\Component\Config\Collection\ConfigCollection;
use Ds\Component\Config\Entity\Config;
use Ds\Component\Entity\Service\EntityService;
use OutOfRangeException;

/**
 * Class ConfigService
 *
 * @package Ds\Component\Config
 */
final class ConfigService extends EntityService
{
    /**
     * @var \Ds\Component\Config\Collection\ConfigCollection
     */
    private $collection;

    /**
     * Constructor
     *
     * @param \Doctrine\ORM\EntityManagerInterface $manager
     * @param \Ds\Component\Config\Collection\ConfigCollection $collection
     * @param string $entity
     */
    public function __construct(EntityManagerInterface $manager, ConfigCollection $collection, $entity = Config::class)
    {
        parent::__construct($manager, $entity);
        $this->collection = $collection;
    }

    /**
     * Get config value
     *
     * @param string $key
     * @return mixed
     * @throws \OutOfRangeException
     */
    public function get(string $key)
    {
        $config = $this->repository->findOneBy(['key' => $key]);

        if (!$config) {
            throw new OutOfRangeException('Config "'.$key.'" does not exist.');
        }

        $this->manager->detach($config);

        return $config->getValue();
    }

    /**
     * Set config value
     *
     * @param string $key
     * @param mixed $value
     */
    public function set(string $key, $value)
    {
        $config = $this->repository->findOneBy(['key' => $key]);

        if (!$config) {
            throw new OutOfRangeException('Config "'.$key.'" does not exist.');
        }

        $config
            ->setKey($key)
            ->setValue($value);
        $this->manager->persist($config);
        $this->manager->flush();
        $this->manager->detach($config);
    }
}
