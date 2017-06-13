<?php

namespace Ds\Component\Model\Attribute;

/**
 * Trait IdentityUuid
 */
trait IdentityUuid
{
    use Accessor\IdentityUuid;

    /**
     * @var string
     */
    protected $identityUuid;
}
