<?php

namespace Ds\Component\Acl\Entity\Attribute\Accessor;

use Ds\Component\Acl\Entity\Permission;

/**
 * Trait Permissions
 *
 * @package Ds\Component\Acl
 */
trait Permissions
{
    /**
     * Set permissions
     *
     * @return object
     */
    public function setPermissions($permissions)
    {
        $this->permissions = $permissions;

        return $this;
    }

    /**
     * Add permission
     *
     * @param \Ds\Component\Acl\Entity\Permission $permission
     * @return object
     */
    public function addPermission(Permission $permission)
    {
        $permission->setAccess($this);
        $this->permissions->add($permission);

        return $this;
    }

    /**
     * Remove permission
     *
     * @param \Ds\Component\Acl\Entity\Permission $permission
     * @return object
     */
    public function removePermission(Permission $permission)
    {
        $this->permissions->removeElement($permission);

        return $this;
    }

    /**
     * Get permissions
     *
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getPermissions()
    {
        return $this->permissions;
    }
}
