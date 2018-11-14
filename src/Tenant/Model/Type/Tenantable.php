<?php

namespace Ds\Component\Tenant\Model\Type;

/**
 * Interface Tenantable
 *
 * @package Ds\Component\Tenant
 */
interface Tenantable
{
    /**
     * Set tenant
     *
     * @param string $tenant
     */
    public function setTenant(?string $tenant);

    /**
     * Get tenant
     *
     * @return string
     */
    public function getTenant(): ?string;
}
