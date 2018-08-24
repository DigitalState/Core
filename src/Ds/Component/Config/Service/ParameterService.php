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

        if (!$parameter) {
            throw new OutOfRangeException('Parameter "'.$key.'" does not exist.');
        }

        if (!$parameter->getEnabled()) {
            return $this->collection->get($key);
        }

        return $parameter->getValue();
    }

    /**
     * Set parameter value
     *
     * @param string $key
     * @param mixed $value
     * @param boolean $enabled
     */
    public function set($key, $value, $enabled = true)
    {
        $parameter = $this->repository->findOneBy(['key' => $key]);

        if (!$parameter) {
            throw new OutOfRangeException('Parameter "'.$key.'" does not exist.');
        }

        $parameter
            ->setKey($key)
            ->setValue($value)
            ->setEnabled($enabled);

        $this->manager->persist($parameter);
        $this->manager->flush();
    }
}
