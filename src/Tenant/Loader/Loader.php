<?php

namespace Ds\Component\Tenant\Loader;

use Ds\Component\Tenant\Entity\Tenant;

/**
 * Interface Loader
 *
 * @package Ds\Component\Tenant
 */
interface Loader
{
    /**
     * Load tenant data
     *
     * @param \Ds\Component\Tenant\Entity\Tenant $tenant
     */
    public function load(Tenant $tenant);
}
