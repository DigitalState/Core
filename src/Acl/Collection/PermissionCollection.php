<?php

namespace Ds\Component\Acl\Collection;

use Doctrine\Common\Collections\ArrayCollection;
use Ds\Component\Acl\Model\Permission;
use InvalidArgumentException;

/**
 * Class PermissionCollection
 *
 * @package Ds\Component\Acl
 */
final class PermissionCollection extends ArrayCollection
{
    /**
     * {@inheritdoc}
     */
    public function __construct(array $permissions = [])
    {
        foreach ($permissions as $key => $permission) {
            $permissions[$key] = $this->cast($permission);
        }

        parent::__construct($permissions);
    }

    /**
     * {@inheritdoc}
     */
    public function removeElement($permission)
    {
        $permission = $this->cast($permission);

        return parent::removeElement($permission);
    }

    /**
     * {@inheritDoc}
     */
    public function contains($permission)
    {
        $permission = $this->cast($permission);

        return parent::contains($permission);
    }

    /**
     * {@inheritDoc}
     */
    public function indexOf($permission)
    {
        $permission = $this->cast($permission);

        return parent::indexOf($permission);
    }

    /**
     * {@inheritDoc}
     */
    public function set($key, $permission)
    {
        $permission = $this->cast($permission);

        return parent::set($key, $permission);
    }

    /**
     * {@inheritDoc}
     */
    public function add($permission)
    {
        $permission = $this->cast($permission);

        return parent::add($permission);
    }

    /**
     * Get parent permission
     *
     * @param \Ds\Component\Acl\Model\Permission $permission
     * @return \Ds\Component\Acl\Model\Permission
     */
    public function getParent($permission) {
        $permission = $this->cast($permission);

        foreach ($this->toArray() as $element) {
            if (Permission::ENTITY === $element->getType() && 0 === strpos($permission->getValue(), $element->getValue())) {
                return $element;
            }
        }
    }

    /**
     * Cast element to permission object
     *
     * @param mixed $element
     * @return \Ds\Component\Acl\Model\Permission
     * @throws \InvalidArgumentException
     */
    protected function cast($element) {
        if ($element instanceof Permission) {
            return $element;
        }

        if (!is_array($element)) {
            throw new InvalidArgumentException('Element is not an array.');
        }

        foreach (['attributes', 'type', 'value', 'title'] as $key) {
            if (!array_key_exists($key, $element)) {
                throw new InvalidArgumentException('Element is missing key "'.$key.'".');
            }
        }

        $permission = new Permission($element['key'], $element['attributes'], $element['type'], $element['value'], $element['title']);

        return $permission;
    }
}
