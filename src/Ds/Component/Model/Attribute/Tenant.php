<?php

namespace Ds\Component\Model\Attribute;

/**
 * Trait Tenant
 *
 * @package Ds\Component\Model
 */
trait Tenant
{
    use Accessor\Tenant;

    /**
     * @var string
     */
    protected $tenant;
}
