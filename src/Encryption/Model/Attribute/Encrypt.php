<?php

namespace Ds\Component\Encryption\Model\Attribute;

/**
 * Trait Encrypt
 *
 * @package Ds\Component\Encryption
 */
trait Encrypt
{
    use Accessor\Encrypt;

    /**
     * @var boolean
     */
    private $encrypt;
}
