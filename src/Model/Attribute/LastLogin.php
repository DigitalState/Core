<?php

namespace Ds\Component\Model\Attribute;

/**
 * Trait LastLogin
 *
 * @package Ds\Component\Model
 */
trait LastLogin
{
    use Accessor\LastLogin;

    /**
     * @var \DateTime
     */
    private $lastLogin;
}
