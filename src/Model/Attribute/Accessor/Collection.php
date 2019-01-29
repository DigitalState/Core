<?php

namespace Ds\Component\Model\Attribute\Accessor;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Trait Collection
 *
 * @package Ds\Component\Model
 */
trait Collection
{
    /**
     * Set collection
     *
     * @param \Doctrine\Common\Collections\ArrayCollection $collection
     * @return object
     */
    public function setCollection(?ArrayCollection $collection)
    {
        $this->collection = $collection;

        return $this;
    }

    /**
     * Get collection
     *
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getCollection(): ?ArrayCollection
    {
        return $this->collection;
    }
}
