<?php

namespace Ds\Component\Model\Attribute;

/**
 * Trait Collection
 *
 * @package Ds\Component\Model
 */
trait Collection
{
    use Accessor\Collection;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $collection;
}
