<?php

namespace Ds\Component\Health\Model\Attribute;

/**
 * Trait Timestamp
 */
trait Timestamp
{
    use Accessor\Timestamp;

    /**
     * @var \DateTime
     */
    protected $timestamp;
}
