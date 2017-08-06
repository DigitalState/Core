<?php

namespace Ds\Component\Api\Model\Attribute;

/**
 * Trait Uuid
 *
 * @package Ds\Component\Api
 */
trait Uuid
{
    use Accessor\Uuid;

    /**
     * @var string
     */
    protected $uuid;
}
