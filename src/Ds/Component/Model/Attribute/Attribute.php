<?php

namespace Ds\Component\Model\Attribute;

/**
 * Trait Attribute
 *
 * @package Ds\Component\Model
 */
trait Attribute
{
    use Accessor\Attribute;

    /**
     * @var string
     */
    protected $attribute;
}
