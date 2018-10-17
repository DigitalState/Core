<?php

namespace Ds\Component\Association\Entity\Attribute\Accessor;

use Ds\Component\Association\Entity\Association;

/**
 * Trait Associations
 *
 * @package Ds\Component\Association
 */
trait Associations
{
    /**
     * Add association
     *
     * @param \Ds\Component\Association\Entity\Association $association
     * @return object
     */
    public function addAssociation(Association $association)
    {
        if (!$this->associations->contains($association)) {
            $this->associations->add($association);
        }

        return $this;
    }

    /**
     * Remove association
     *
     * @param \Ds\Component\Association\Entity\Association $association
     * @return object
     */
    public function removeAssociation(Association $association)
    {
        if ($this->associations->contains($association)) {
            $this->associations->removeElement($association);
        }

        return $this;
    }

    /**
     * Get associations
     *
     * @return array
     */
    public function getAssociations()
    {
        return $this->associations->toArray();
    }
}
