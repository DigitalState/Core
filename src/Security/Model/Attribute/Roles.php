<?php

namespace Ds\Component\Security\Model\Attribute;

/**
 * Trait Roles
 *
 * @package Ds\Component\Security
 */
trait Roles
{
    use Accessor\Roles;

    /**
     * @var array
     */
    private $roles;
}
