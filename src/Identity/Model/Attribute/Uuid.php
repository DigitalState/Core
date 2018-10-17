<?php

namespace Ds\Component\Identity\Model\Attribute;

/**
 * Trait Uuid
 *
 * @package Ds\Component\Identity
 */
trait Uuid
{
    use Accessor\Uuid;

    /**
     * @var string
     */
    protected $uuid;
}
