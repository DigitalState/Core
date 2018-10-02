<?php

namespace Ds\Component\Config\Service;

use Doctrine\ORM\EntityManager;
use Ds\Component\Config\Collection\ParameterCollection;
use Ds\Component\Config\Entity\Parameter;
use Ds\Component\Entity\Service\EntityService;
use OutOfRangeException;

/**
 * Class ParameterService
 *
 * @package Ds\Component\Config
 */
class ParameterService extends EntityService
{
    /**
     * @var \Ds\Component\Config\Collection\ParameterCollection
     */
    protected $collection;

    /**
     * Constructor
     *
     * @param \Doctrine\ORM\EntityManager $manager
     * @param \Ds\Component\Config\Collection\ParameterCollection $collection
     * @param string $entity
     */
    public function __construct(EntityManager $manager, ParameterCollection $collection, $entity = Parameter::class)
    {
        parent::__construct($manager, $entity);
        $this->collection = $collection;
    }

    /**
     * Get parameter value
     *
     * @param string $key
     * @return mixed
     * @throws \OutOfRangeException
     */
    public function get($key)
    {
        $parameter = $this->repository->findOneBy(['key' => $key]);
        $this->manager->detach($parameter);

        if (!$parameter) {
            throw new OutOfRangeException('Parameter "'.$key.'" does not exist.');
        }

        return $parameter->getValue();
    }

    /**
     * Set parameter value
     *
     * @param string $key
     * @param mixed $value
     */
    public function set($key, $value)
    {
        $parameter = $this->repository->findOneBy(['key' => $key]);

        if (!$parameter) {
            throw new OutOfRangeException('Parameter "'.$key.'" does not exist.');
        }

        $parameter
            ->setKey($key)
            ->setValue($value);
        $this->manager->persist($parameter);
        $this->manager->flush();
        $this->manager->detach($parameter);
    }
}
