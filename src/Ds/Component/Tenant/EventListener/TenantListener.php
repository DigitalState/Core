<?php

namespace Ds\Component\Tenant\EventListener;

use Doctrine\ORM\EntityManager;
use Ds\Component\Tenant\Doctrine\ORM\Filter\TenantFilter;
use Ds\Component\Tenant\Service\TenantService;

/**
 * Class TenantListener
 *
 * @package Ds\Component\Tenant
 */
class TenantListener
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $entityManager;

    /**
     * @var \Ds\Component\Tenant\Service\TenantService
     */
    protected $tenantService;

    /**
     * Constructor
     *
     * @param \Doctrine\ORM\EntityManager $entityManager
     * @param \Ds\Component\Tenant\Service\TenantService $tenantService
     */
    public function __construct(EntityManager $entityManager, TenantService $tenantService)
    {
        $this->entityManager = $entityManager;
        $this->tenantService = $tenantService;
    }

    /**
     * Determine the contextual tenant prior to authentication
     */
    public function onPreAuthentication()
    {
        $this->entityManager->getConfiguration()->addFilter('tenant', TenantFilter::class);
        $filter = $this->entityManager->getFilters()->enable('tenant');
        $tenant = $this->tenantService->getTenant();
        $filter->setParameter('tenant', (string) $tenant);
    }

    /**
     * Determine the contextual tenant after authentication
     */
    public function onPostAuthentication()
    {
        $filter = $this->entityManager->getFilters()->enable('tenant');
        $tenant = $this->tenantService->getTenant();
        $filter->setParameter('tenant', (string) $tenant);
    }
}
