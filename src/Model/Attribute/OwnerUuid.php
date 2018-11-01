<?php

namespace Ds\Component\Model\Attribute;

/**
 * Trait OwnerUuid
 *
 * @package Ds\Component\Model
 */
trait OwnerUuid
{
    use Accessor\OwnerUuid;

    /**
     * @var string
     */
    private $ownerUuid;
}
