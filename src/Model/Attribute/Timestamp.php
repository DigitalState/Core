<?php

namespace Ds\Component\Model\Attribute;

/**
 * Trait Timestamp
 *
 * @package Ds\Component\Model
 */
trait Timestamp
{
    use Accessor\Timestamp;

    /**
     * @var \DateTime
     */
    private $timestamp;
}
