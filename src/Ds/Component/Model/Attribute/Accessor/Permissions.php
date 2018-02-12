<?php

namespace Ds\Component\Model\Attribute\Accessor;

use OutOfRangeException;

/**
 * Trait Permissions
 *
 * @package Ds\Component\Model
 */
trait Permissions
{
    /**
     * Set permissions
     *
     * @param array $permissions
     * @return object
     */
    public function setPermissions($permissions)
    {
        $this->permissions = $permissions;

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
