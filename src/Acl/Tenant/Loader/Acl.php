<?php

namespace Ds\Component\Acl\Tenant\Loader;

use Ds\Component\Database\Util\Objects;
use Ds\Component\Tenant\Entity\Tenant;

/**
 * Trait Acl
 *
 * @package Ds\Component\Acl
 */
trait Acl
{
    /**
     * @var \Ds\Component\Acl\Service\AccessService
     */
    private $accessService;

    /**
     * @var \Ds\Component\Acl\Service\PermissionService
     */
    private $permissionService;

    /**
     * @var string
     */
    private $path;

    /**
     * {@inheritdoc}
     */
    public function load(Tenant $tenant)
    {
        $data = (array) json_decode(json_encode($tenant->getData()));
        $objects = Objects::parseFile($this->path, $data);
        $manager = $this->accessService->getManager();

        foreach ($objects as $object) {
            $access = $this->accessService->createInstance();
            $access
                ->setOwner($object->owner)
                ->setOwnerUuid($object->owner_uuid)
                ->setAssignee($object->assignee)
                ->setAssigneeUuid($object->assignee_uuid)
                ->setTenant($object->tenant);

            foreach ($object->permissions as $subObject) {
                $permission = $this->permissionService->createInstance();
                $permission
                    ->setScope((array) $subObject->scope)
                    ->setKey($subObject->key)
                    ->setAttributes($subObject->attributes)
                    ->setTenant($object->tenant);
                $access->addPermission($permission);
            }

            $manager->persist($access);
            $manager->flush();
            $manager->detach($access);

            foreach ($access->getPermissions() as $permission) {
                $manager->detach($permission);
            }
        }
    }
}
