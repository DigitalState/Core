<?php

namespace Ds\Component\Security\Fixture\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Ds\Component\Security\Entity\Access;
use Ds\Component\Security\Entity\Permission;
use Ds\Component\Database\Fixture\ORM\ResourceFixture;

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
            if (!is_array($permission['key'])) {
                $permission['key'] = [$permission['key']];
            }

            foreach ($permission['key'] as $key) {
                $entity = new Permission;
                $entity
                    ->setAccess($manager->getRepository(Access::class)->findOneBy(['uuid' => $permission['access']]))
                    ->setEntity($permission['entity'])
                    ->setEntityUuid($permission['entity_uuid'])
                    ->setKey($key)
                    ->setAttributes($permission['attributes']);
                $manager->persist($entity);
                $manager->flush();
            }
        }
    }

    /**
     * Get resource
     *
     * @return string
     */
    abstract protected function getResource();
}
