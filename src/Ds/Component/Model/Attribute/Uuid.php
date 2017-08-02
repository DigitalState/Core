<?php

namespace Ds\Component\Model\Attribute;

/**
 * Trait Uuid
 *
 * @package Ds\Component\Model
 */
trait Uuid
{
    use Accessor\Uuid;

    /**
     * @var string
     */
    protected $uuid;
}
