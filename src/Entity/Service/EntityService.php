<?php

namespace Ds\Component\Entity\Service;

use Doctrine\ORM\EntityManagerInterface;

/**
 * Class EntityService
 *
 * @package Ds\Component\Entity
 */
class EntityService
{
    /**
     * @var \Doctrine\ORM\EntityManagerInterface
     */
    protected $manager;

    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    protected $repository;

    /**
     * @var string
     */
    protected $entity;

    /**
     * Constructor
     *
     * @param \Doctrine\ORM\EntityManagerInterface $manager
     * @param string $entity
     */
    public function __construct(EntityManagerInterface $manager, string $entity)
    {
        $this->manager = $manager;
        $this->repository = $manager->getRepository($entity);
        $this->entity = $entity;
    }

    /**
     * Get manager
     *
     * @return \Doctrine\ORM\EntityManager
     */
    public function getManager()
    {
        return $this->manager;
    }

    /**
     * Get repository
     *
     * @return \Doctrine\ORM\EntityRepository
     */
    public function getRepository()
    {
        return $this->repository;
    }

    /**
     * Get entity
     *
     * @return string
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * Create entity instance
     *
     * @return object
     */
    public function createInstance()
    {
        return new $this->entity;
    }
}
