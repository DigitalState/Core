<?php

namespace Ds\Component\Api\Model\Attribute\Accessor;

use Ds\Component\Api\Model\Permission;
use OutOfRangeException;

/**
 * Trait Permissions
 *
 * @package Ds\Component\Api
 */
trait Permissions
{
    /**
     * Set permissions
     *
     * @param array $permissions
     * @return object
     */
    public function setPermissions(array $permissions = [])
    {
        $this->permissions = $permissions;

        return $this;
    }

    /**
     * Add permission
     *
     * @param $permission
     * @return $this
     */
    public function addPermission(Permission $permission)
    {
        $this->permissions[] = $permission;

        return $this;
    }

    /**
     * Get permissions
     *
     * @param string $property
     * @return array
     * @throws \OutOfRangeException
     */
    public function getPermissions($property = null)
    {
        if (null === $property) {
            return $this->permissions;
        }

        if (!array_key_exists($property, $this->permissions)) {
            throw new OutOfRangeException('Array property does not exist.');
        }

        return $this->permissions[$property];
    }
}
