<?php

namespace Ds\Component\Model\Attribute;

/**
 * Trait Owner
 */
trait Owner
{
    use Accessor\Owner;

    /**
     * @var string
     */
    protected $owner;
}
