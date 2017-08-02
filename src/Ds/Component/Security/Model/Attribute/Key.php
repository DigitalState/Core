<?php

namespace Ds\Component\Security\Model\Attribute;

/**
 * Trait Key
 *
 * @package Ds\Component\Security
 */
trait Key
{
    use Accessor\Key;

    /**
     * @var string
     */
    protected $key;
}
