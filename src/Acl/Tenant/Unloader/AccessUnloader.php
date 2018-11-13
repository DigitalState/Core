<?php

namespace Ds\Component\Acl\Tenant\Unloader;

use Doctrine\ORM\EntityManagerInterface;
use Ds\Component\Acl\Entity\Access;
use Ds\Component\Tenant\Entity\Tenant;
use Ds\Component\Tenant\Loader\Unloader;

/**
 * Class AccessUnloader
 *
 * @package Ds\Component\Acl
 */
final class AccessUnloader implements Unloader
{
    /**
     * @var \Doctrine\ORM\EntityManagerInterface
     */
    private $entityManager;

    /**
     * Constructor
     *
     * @param \Doctrine\ORM\EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
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
