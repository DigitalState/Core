<?php

namespace Ds\Component\Api\Model\Attribute\Accessor;

use Ds\Component\Api\Model\Role as RoleModel;

/**
 * Trait Role
 *
 * @package Ds\Component\Api
 */
trait Role
{
    /**
     * Set role
     *
     * @param \Ds\Component\Api\Model\Role $role
     * @return object
     */
    public function setRole(?RoleModel $role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return \Ds\Component\Api\Model\Role
     */
    public function getRole(): ?RoleModel
    {
        return $this->role;
    }
}
