<?php

namespace Ds\Component\Model\Attribute;

/**
 * Trait EntityUuid
 *
 * @package Ds\Component\Model
 */
trait EntityUuid
{
    use Accessor\EntityUuid;

    /**
     * @var string
     */
    private $entityUuid;
}
