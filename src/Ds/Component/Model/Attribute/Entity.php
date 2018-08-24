<?php

namespace Ds\Component\Model\Attribute;

/**
 * Trait Entity
 *
 * @package Ds\Component\Model
 */
trait Entity
{
    use Accessor\Entity;

    /**
     * @var string
     */
    protected $entity;
}
