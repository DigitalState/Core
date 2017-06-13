<?php

namespace Ds\Component\Model\Attribute;

/**
 * Trait UpdatedAt
 */
trait UpdatedAt
{
    use Accessor\UpdatedAt;

    /**
     * @var \DateTime
     */
    protected $updatedAt;
}
