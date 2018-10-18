<?php

namespace Ds\Component\Model\Attribute;

/**
 * Trait Password
 *
 * @package Ds\Component\Model
 */
trait Password
{
    use Accessor\Password;

    /**
     * @var string
     */
    private $password;
}
