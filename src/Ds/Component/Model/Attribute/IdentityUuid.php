<?php

namespace Ds\Component\Model\Attribute;

/**
 * Trait IdentityUuid
 *
 * @package Ds\Component\Model
 */
trait IdentityUuid
{
    use Accessor\IdentityUuid;

    /**
     * @var string
     */
    protected $identityUuid;
}
