<?php

namespace Ds\Component\Tenant\Loader;

use Ds\Component\Tenant\Entity\Tenant;

/**
 * Interface Unloader
 *
 * @package Ds\Component\Tenant
 */
interface Unloader
{
    /**
     * Unload tenant data
     *
     * @param \Ds\Component\Tenant\Entity\Tenant $tenant
     * @return \Ds\Component\Tenant\Loader\Unloader
     */
    public function unload(Tenant $tenant);
}
