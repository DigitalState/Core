<?php

namespace Ds\Component\Tenant\EventListener\Entity;

use Ds\Component\Container\EventListener\ContainerListener;
use Ds\Component\Tenant\Entity\Tenant;

/**
 * Class TenantListener
 *
 * @package Ds\Component\Tenant
 */
class TenantListener extends ContainerListener
{
    /**
     * Load related data when a system tenant is created
     *
     * @param \Ds\Component\Tenant\Entity\Tenant $tenant
     */
    public function postPersist(Tenant $tenant)
    {
        $this->container->get('ds_tenant.service.tenant')->load($tenant);
    }

    /**
     * Delete related data when a system tenant is deleted
     *
     * @param \Ds\Component\Tenant\Entity\Tenant $tenant
     */
    public function postRemove(Tenant $tenant)
    {
        $this->container->get('ds_tenant.service.tenant')->unload($tenant);
    }
}
