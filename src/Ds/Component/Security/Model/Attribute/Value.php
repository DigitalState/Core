<?php

namespace Ds\Component\Security\Model\Attribute;

/**
 * Trait Value
 *
 * @package Ds\Component\Security
 */
trait Value
{
    use Accessor\Value;

    /**
     * @var string
     */
    protected $value;
}
