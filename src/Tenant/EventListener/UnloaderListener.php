<?php

namespace Ds\Component\Tenant\EventListener;

use Ds\Component\Container\EventListener\ContainerListener;
use Ds\Component\Tenant\Entity\Tenant;

/**
 * Class UnloaderListener
 *
 * @package Ds\Component\Tenant
 */
final class UnloaderListener extends ContainerListener
{
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
