<?php

namespace Ds\Component\Security\Model\Attribute;

/**
 * Trait Uuid
 *
 * @package Ds\Component\Security
 */
trait Uuid
{
    use Accessor\Uuid;

    /**
     * @var string
     */
    private $uuid;
}
