<?php

namespace Ds\Component\Model\Attribute;

/**
 * Trait EntityUuid
 */
trait EntityUuid
{
    use Accessor\EntityUuid;

    /**
     * @var string
     */
    protected $entityUuid;
}
