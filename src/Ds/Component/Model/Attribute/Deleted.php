<?php

namespace Ds\Component\Model\Attribute;

/**
 * Trait Deleted
 */
trait Deleted
{
    use Accessor\Deleted;

    /**
     * @var boolean
     */
    protected $deleted;
}
