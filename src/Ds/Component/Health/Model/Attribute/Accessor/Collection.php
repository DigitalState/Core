<?php

namespace Ds\Component\Health\Model\Attribute\Accessor;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Trait Collection
 */
trait Collection
{
    /**
     * Set collection
     *
     * @param \Doctrine\Common\Collections\ArrayCollection $collection
     * @return object
     */
    public function setCollection(ArrayCollection $collection)
    {
        $this->collection = $collection;

        return $this;
    }

    /**
     * Get collection
     *
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getCollection()
    {
        return $this->collection;
    }
}
