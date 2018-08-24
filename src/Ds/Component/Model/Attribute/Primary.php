<?php

namespace Ds\Component\Model\Attribute;

/**
 * Trait Primary
 *
 * @package Ds\Component\Model
 */
trait Primary
{
    use Accessor\Primary;

    /**
     * @var boolean
     */
    protected $primary;
}
