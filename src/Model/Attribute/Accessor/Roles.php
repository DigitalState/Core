<?php

namespace Ds\Component\Model\Attribute\Accessor;

/**
 * Trait Roles
 *
 * @package Ds\Component\Model
 */
trait Roles
{
    /**
     * Set roles
     *
     * @param array $roles
     * @return object
     */
    public function setRoles(?array $roles)
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Get roles
     *
     * @return array
     */
    public function getRoles(): ?array
    {
        return $this->roles;
    }
}
