<?php

namespace Ds\Component\Model\Attribute;

/**
 * Trait FollowUpAt
 *
 * @package Ds\Component\Model
 */
trait FollowUpAt
{
    use Accessor\FollowUpAt;

    /**
     * @var \DateTime
     */
    protected $createdAt;
}
