<?php

namespace Ds\Component\Model\Attribute;

/**
 * Trait Entity
 */
trait Entity
{
    use Accessor\Entity;

    /**
     * @var string
     */
    protected $entity;
}
