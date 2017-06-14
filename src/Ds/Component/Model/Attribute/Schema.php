<?php

namespace Ds\Component\Model\Attribute;

/**
 * Trait Schema
 */
trait Schema
{
    use Accessor\Schema;

    /**
     * @var \stdClass|array
     */
    protected $schema;
}
