<?php

namespace Ds\Component\Parameter\Service;

use Doctrine\ORM\EntityManagerInterface;
use Ds\Component\Parameter\Collection\ParameterCollection;
use Ds\Component\Parameter\Entity\Parameter;
use Ds\Component\Entity\Service\EntityService;
use OutOfRangeException;

/**
 * Class ParameterService
 *
 * @package Ds\Component\Parameter
 */
final class ParameterService extends EntityService
{
    /**
     * @var \Ds\Component\Parameter\Collection\ParameterCollection
     */
    private $collection;

    /**
     * Constructor
     *
     * @param \Doctrine\ORM\EntityManagerInterface $manager
     * @param \Ds\Component\Parameter\Collection\ParameterCollection $collection
     * @param string $entity
     */
    public function __construct(EntityManagerInterface $manager, ParameterCollection $collection, $entity = Parameter::class)
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
    public function get(string $key)
    {
        $parameter = $this->repository->findOneBy(['key' => $key]);

        if (!$parameter) {
            throw new OutOfRangeException('Parameter "'.$key.'" does not exist.');
        }

        $this->manager->detach($parameter);

        return $parameter->getValue();
    }

    /**
     * Set parameter value
     *
     * @param string $key
     * @param mixed $value
     */
    public function set(string $key, $value)
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
