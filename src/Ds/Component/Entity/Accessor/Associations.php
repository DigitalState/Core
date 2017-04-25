<?php

namespace Ds\Component\Entity\Accessor;

use Ds\Component\Entity\Entity\Association;

/**
 * Trait Associations
 */
trait Associations
{
    /**
     * Add association
     *
     * @param \Ds\Component\Entity\Entity\Association $association
     * @return \Ds\Bundle\CaseBundle\Entity\CaseEntity
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
     * @param \Ds\Component\Entity\Entity\Association $association
     * @return \Ds\Bundle\CaseBundle\Entity\CaseEntity
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
