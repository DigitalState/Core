<?php

namespace Ds\Component\Model\Attribute;

/**
 * Trait Resource
 *
 * @package Ds\Component\Model
 */
trait Resource
{
    use Accessor\Resource;

    /**
     * @var mixed
     */
    protected $resource;
}
