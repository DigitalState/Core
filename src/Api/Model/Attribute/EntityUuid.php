<?php

namespace Ds\Component\Api\Model\Attribute;

/**
 * Trait EntityUuid
 *
 * @package Ds\Component\Api
 */
trait EntityUuid
{
    use Accessor\EntityUuid;

    /**
     * @var string
     */
    private $entityUuid;
}
