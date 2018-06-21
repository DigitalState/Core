<?php

namespace Ds\Component\Tenant\EventListener\Entity;

use Ds\Component\Tenant\Entity\Tenant;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class TenantListener
 *
 * @package Ds\Component\Tenant
 */
class TenantListener
{
    /**
     * @var \Symfony\Component\DependencyInjection\ContainerInterface
     */
    protected $container;

    /**
     * @var \Ds\Component\Tenant\Service\TenantService
     */
    protected $tenantService;

    /**
     * Constructor
     *
     * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Load tenant
     *
     * @param \Ds\Component\Tenant\Entity\Tenant $tenant
     */
    public function postPersist(Tenant $tenant)
    {
        // Circular reference error workaround
        $this->tenantService = $this->container->get('ds_tenant.service.tenant');
        //

        $data = $tenant->getData();
        $data['tenant']['uuid'] = $tenant->getUuid();
        $this->tenantService->load($data);
    }
}
