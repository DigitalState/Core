<?php

namespace Ds\Component\Identity\Model\Attribute\Accessor;

/**
 * Trait Roles
 *
 * @package Ds\Component\Identity
 */
trait Roles
{
    /**
     * Set roles
     *
     * @param array $roles
     * @return object
     * @throws \InvalidArgumentException
     */
    public function setRoles(array $roles)
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Get roles
     *
     * @return array
     */
    public function getRoles()
    {
        return $this->roles;
    }
}
