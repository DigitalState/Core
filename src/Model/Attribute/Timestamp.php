<?php

namespace Ds\Component\Model\Attribute;

/**
 * Trait Timestamp
 */
trait Timestamp
{
    use Accessor\Timestamp;

    /**
     * @var \DateTime
     */
    private $timestamp;
}
