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
     * @return \Ds\Component\Tenant\Loader\Loader
     */
    public function load(Tenant $tenant);
}
