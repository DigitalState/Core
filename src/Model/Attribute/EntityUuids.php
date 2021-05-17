<?php

namespace Ds\Component\Model\Attribute;

/**
 * Trait EntityUuids
 *
 * @package Ds\Component\Model
 */
trait EntityUuids
{
    use Accessor\EntityUuids;

    /**
     * @var array
     */
    private $entityUuids;
}
