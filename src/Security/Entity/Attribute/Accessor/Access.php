<?php

namespace Ds\Component\Security\Entity\Attribute\Accessor;

use Ds\Component\Security\Entity\Access as AccessEntity;

/**
 * Trait Access
 */
trait Access
{
    /**
     * Set access
     *
     * @param \Ds\Component\Security\Entity\Access $access
     * @return object
     */
    public function setAccess(AccessEntity $access = null)
    {
        $this->access = $access;

        return $this;
    }

    /**
     * Get access
     *
     * @return \Ds\Component\Security\Entity\Access
     */
    public function getAccess()
    {
        return $this->access;
    }
}
