<?php

namespace Ds\Component\Model\Attribute;

/**
 * Trait Schema
 *
 * @package Ds\Component\Model
 */
trait Schema
{
    use Accessor\Schema;

    /**
     * @var \stdClass|array
     */
    protected $schema;
}
