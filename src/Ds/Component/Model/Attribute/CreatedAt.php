<?php

namespace Ds\Component\Model\Attribute;

/**
 * Trait CreatedAt
 */
trait CreatedAt
{
    use Accessor\CreatedAt;

    /**
     * @var \DateTime
     */
    protected $createdAt;
}
