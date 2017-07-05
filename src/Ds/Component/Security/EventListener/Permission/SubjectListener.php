<?php

namespace Ds\Component\Security\EventListener\Permission;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Ds\Component\Security\Collection\PermissionCollection;
use Ds\Component\Security\Entity\Permission;
use UnexpectedValueException;

/**
 * Class SubjectListener
 */
class SubjectListener
{
    /**
     * @var \Ds\Component\Security\Collection\PermissionCollection
     */
    protected $permissionCollection;

    /**
     * Constructor
     *
     * @param \Ds\Component\Security\Collection\PermissionCollection $permissionCollection
     */
    public function __construct(PermissionCollection $permissionCollection)
    {
        $this->permissionCollection = $permissionCollection;
    }

    /**
     * Post load
     *
     * @param \Ds\Component\Security\Entity\Permission $permission
     * @param \Doctrine\ORM\Event\LifecycleEventArgs $event
     * @throws \UnexpectedValueException
     */
    public function postLoad(Permission $permission, LifecycleEventArgs $event)
    {
        $item = $this->permissionCollection->get($permission->getKey());

        if (!$item) {
            throw new UnexpectedValueException('Permission does not exist.');
        }

        $permission
            ->setType($item['type'])
            ->setSubject($item['subject']);
    }
}
