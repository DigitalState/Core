<?php

namespace Ds\Component\Identity\Model\Attribute;

/**
 * Trait Roles
 *
 * @package Ds\Component\Identity
 */
trait Roles
{
    use Accessor\Roles;

    /**
     * @var array
     */
    protected $roles;
}
