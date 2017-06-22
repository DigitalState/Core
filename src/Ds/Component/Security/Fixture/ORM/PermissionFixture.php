<?php

namespace Ds\Component\Security\Fixture\ORM;

use Ds\Component\Migration\Fixture\ORM\ResourceFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Ds\Component\Security\Entity\Permission;

/**
 * Class PermissionFixture
 */
abstract class PermissionFixture extends ResourceFixture
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $permissions = $this->parse($this->getResource());

        foreach ($permissions as $permission) {
            $entity = new Permission;
            $entity
                ->setUuid($permission['uuid'])
                ->setOwner($permission['owner'])
                ->setOwnerUuid($permission['owner_uuid'])
                ->setUserUuid($permission['user_uuid']);
            $manager->persist($entity);
            $manager->flush();
        }
    }

    /**
     * Get resource
     *
     * @return string
     */
    abstract protected function getResource();
}
