<?php

namespace Ds\Component\Tenant\EventListener;

use Doctrine\ORM\EntityManager;
use Ds\Component\Tenant\Doctrine\ORM\Filter\TenantFilter;
use Ds\Component\Tenant\Service\TenantService;

/**
 * Class ContextListener
 *
 * @package Ds\Component\Tenant
 */
class ContextListener
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
     * Determine the contextual tenant
     */
    public function onKernelRequest()
    {
        $this->entityManager->getConfiguration()->addFilter('tenant', TenantFilter::class);
        $filter = $this->entityManager->getFilters()->enable('tenant');
        $tenant = $this->tenantService->getContext();
        $filter->setParameter('tenant', (string) $tenant);
    }
}
