<?php

namespace Ds\Component\Api\Model\Attribute;

/**
 * Trait Permissions
 *
 * @package Ds\Component\Api
 */
trait Permissions
{
    use Accessor\Permissions;

    /**
     * @var array
     */
    private $permissions;
}
