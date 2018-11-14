<?php

namespace Ds\Component\Tenant\EventListener;

use Ds\Component\Container\EventListener\ContainerListener;
use Ds\Component\Tenant\Entity\Tenant;

/**
 * Class LoaderListener
 *
 * @package Ds\Component\Tenant
 */
final class LoaderListener extends ContainerListener
{
    /**
     * Load related data when a system tenant is persisted
     *
     * @param \Ds\Component\Tenant\Entity\Tenant $tenant
     */
    public function prePersist(Tenant $tenant)
    {
        $this->container->get('ds_tenant.service.tenant')->load($tenant);
    }
}
