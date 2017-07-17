<?php

namespace Ds\Component\Health\Model\Attribute;

/**
 * Trait Collection
 */
trait Collection
{
    use Accessor\Collection;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    protected $collection;
}
