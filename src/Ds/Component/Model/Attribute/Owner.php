<?php

namespace Ds\Component\Model\Attribute;

/**
 * Trait Owner
 *
 * @package Ds\Component\Model
 */
trait Owner
{
    use Accessor\Owner;

    /**
     * @var string
     */
    protected $owner;
}
