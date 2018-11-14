<?php

namespace Ds\Component\Tenant\EventListener;

use Doctrine\ORM\EntityManagerInterface;
use Ds\Component\Tenant\Doctrine\ORM\Filter\TenantFilter;
use Ds\Component\Tenant\Service\TenantService;

/**
 * Class ContextListener
 *
 * @package Ds\Component\Tenant
 */
final class ContextListener
{
    /**
     * @var \Doctrine\ORM\EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var \Ds\Component\Tenant\Service\TenantService
     */
    private $tenantService;

    /**
     * Constructor
     *
     * @param \Doctrine\ORM\EntityManagerInterface $entityManager
     * @param \Ds\Component\Tenant\Service\TenantService $tenantService
     */
    public function __construct(EntityManagerInterface $entityManager, TenantService $tenantService)
    {
        $this->entityManager = $entityManager;
        $this->tenantService = $tenantService;
    }

    /**
     * Determine the contextual tenant
     */
    public function onPreAuthentication()
    {
        $this->entityManager->getConfiguration()->addFilter('tenant', TenantFilter::class);
        $filter = $this->entityManager->getFilters()->enable('tenant');
        $tenant = $this->tenantService->getContext();
        $filter->setParameter('tenant', (string) $tenant);
    }

    /**
     * Determine the contextual tenant
     */
    public function onPostAuthentication()
    {
        $filter = $this->entityManager->getFilters()->enable('tenant');
        $tenant = $this->tenantService->getContext();
        $filter->setParameter('tenant', (string) $tenant);
    }
}
