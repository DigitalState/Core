<?php

namespace Ds\Component\Model\Attribute;

/**
 * Trait Value
 *
 * @package Ds\Component\Model
 */
trait Value
{
    use Accessor\Value;

    /**
     * @var mixed
     */
    private $value;
}
