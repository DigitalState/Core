<?php

namespace Ds\Component\Security\Tenant\Unloader;

use Doctrine\ORM\EntityManager;
use Ds\Component\Security\Entity\Access;
use Ds\Component\Tenant\Entity\Tenant;
use Ds\Component\Tenant\Loader\Unloader;

/**
 * Class AccessUnloader
 *
 * @package Ds\Component\Security
 */
class AccessUnloader implements Unloader
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $entityManager;

    /**
     * Constructor
     *
     * @param \Doctrine\ORM\EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * {@inheritdoc}
     */
    public function unload(Tenant $tenant)
    {
        $builder = $this->entityManager->getRepository(Access::class)->createQueryBuilder('e');
        $builder
            ->delete()
            ->where('e.tenant = :tenant')
            ->setParameter('tenant', $tenant->getUuid());
        $query = $builder->getQuery();
        $query->execute();
    }
}
