<?php

namespace Ds\Component\Model\Attribute;

/**
 * Trait OwnerUuid
 */
trait OwnerUuid
{
    use Accessor\OwnerUuid;

    /**
     * @var string
     */
    protected $ownerUuid;
}
