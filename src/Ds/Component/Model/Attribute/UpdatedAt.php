<?php

namespace Ds\Component\Model\Attribute;

/**
 * Trait UpdatedAt
 *
 * @package Ds\Component\Model
 */
trait UpdatedAt
{
    use Accessor\UpdatedAt;

    /**
     * @var \DateTime
     */
    protected $updatedAt;
}
