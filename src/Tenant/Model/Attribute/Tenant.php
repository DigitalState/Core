<?php

namespace Ds\Component\Tenant\Model\Attribute;

/**
 * Trait Tenant
 *
 * @package Ds\Component\Tenant
 */
trait Tenant
{
    use Accessor\Tenant;

    /**
     * @var string
     */
    protected $tenant;
}
