<?php

namespace Ds\Component\Acl\Entity\Attribute\Accessor;

use Ds\Component\Acl\Entity\Access as AccessEntity;

/**
 * Trait Access
 *
 * @package Ds\Component\Acl
 */
trait Access
{
    /**
     * Set access
     *
     * @param \Ds\Component\Acl\Entity\Access $access
     * @return object
     */
    public function setAccess(?AccessEntity $access)
    {
        $this->access = $access;

        return $this;
    }

    /**
     * Get access
     *
     * @return \Ds\Component\Acl\Entity\Access
     */
    public function getAccess(): ?AccessEntity
    {
        return $this->access;
    }
}
