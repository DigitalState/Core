<?php

namespace Ds\Component\Model\Attribute;

/**
 * Trait DueAt
 *
 * @package Ds\Component\Model
 */
trait DueAt
{
    use Accessor\DueAt;

    /**
     * @var \DateTime
     */
    protected $createdAt;
}
