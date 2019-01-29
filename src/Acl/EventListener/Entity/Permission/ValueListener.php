<?php

namespace Ds\Component\Acl\EventListener\Entity\Permission;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Ds\Component\Acl\Collection\PermissionCollection;
use Ds\Component\Acl\Entity\Permission;
use UnexpectedValueException;

/**
 * Class ValueListener
 *
 * @package Ds\Component\Acl
 */
final class ValueListener
{
    /**
     * @var \Ds\Component\Acl\Collection\PermissionCollection
     */
    private $permissionCollection;

    /**
     * Constructor
     *
     * @param \Ds\Component\Acl\Collection\PermissionCollection $permissionCollection
     */
    public function __construct(PermissionCollection $permissionCollection)
    {
        $this->permissionCollection = $permissionCollection;
    }

    /**
     * Hydrate the permission entity with permission configurations
     *
     * @param \Ds\Component\Acl\Entity\Permission $permission
     * @param \Doctrine\ORM\Event\LifecycleEventArgs $event
     * @throws \UnexpectedValueException
     */
    public function postLoad(Permission $permission, LifecycleEventArgs $event)
    {
        $item = $this->permissionCollection->get($permission->getKey());

        if (!$item) {
            throw new UnexpectedValueException('Permission "'.$permission->getKey().'" does not exist.');
        }

        $permission
            ->setType($item->getType())
            ->setValue($item->getValue());
    }
}
