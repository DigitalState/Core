<?php

namespace Ds\Component\Model\Attribute;

/**
 * Trait Permissions
 *
 * @package Ds\Component\Model
 */
trait Permissions
{
    use Accessor\Permissions;

    /**
     * @var array
     */
    protected $permissions;
}
