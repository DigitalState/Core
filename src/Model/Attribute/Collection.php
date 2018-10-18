<?php

namespace Ds\Component\Model\Attribute;

/**
 * Trait Collection
 */
trait Collection
{
    use Accessor\Collection;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $collection;
}
