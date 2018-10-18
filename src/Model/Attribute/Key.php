<?php

namespace Ds\Component\Model\Attribute;

/**
 * Trait Key
 *
 * @package Ds\Component\Model
 */
trait Key
{
    use Accessor\Key;

    /**
     * @var string
     */
    private $key;
}
