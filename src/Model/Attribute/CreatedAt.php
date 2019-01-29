<?php

namespace Ds\Component\Model\Attribute;

/**
 * Trait CreatedAt
 *
 * @package Ds\Component\Model
 */
trait CreatedAt
{
    use Accessor\CreatedAt;

    /**
     * @var \DateTime
     */
    private $createdAt;
}
