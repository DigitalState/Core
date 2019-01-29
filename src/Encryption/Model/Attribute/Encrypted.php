<?php

namespace Ds\Component\Encryption\Model\Attribute;

/**
 * Trait Encrypted
 *
 * @package Ds\Component\Encryption
 */
trait Encrypted
{
    use Accessor\Encrypted;

    /**
     * @var boolean
     */
    private $encrypted;
}
