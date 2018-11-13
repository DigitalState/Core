<?php

namespace Ds\Component\Config\Tenant\Unloader;

use Doctrine\ORM\EntityManagerInterface;
use Ds\Component\Config\Entity\Config;
use Ds\Component\Tenant\Entity\Tenant;
use Ds\Component\Tenant\Loader\Unloader;

/**
 * Class ConfigUnloader
 *
 * @package Ds\Component\Config
 */
final class ConfigUnloader implements Unloader
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
        $builder = $this->entityManager->getRepository(Config::class)->createQueryBuilder('e');
        $builder
            ->delete()
            ->where('e.tenant = :tenant')
            ->setParameter('tenant', $tenant->getUuid());
        $query = $builder->getQuery();
        $query->execute();
    }
}
