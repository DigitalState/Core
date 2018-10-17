<?php

namespace Ds\Component\Model\Attribute;

/**
 * Trait Identity
 *
 * @package Ds\Component\Model
 */
trait Identity
{
    use Accessor\Identity;

    /**
     * @var string
     */
    protected $identity;
}
