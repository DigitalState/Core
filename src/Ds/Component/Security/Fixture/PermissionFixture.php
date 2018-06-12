<?php

namespace Ds\Component\Security\Fixture;

use Doctrine\Common\Persistence\ObjectManager;
use Ds\Component\Security\Entity\Access;
use Ds\Component\Security\Entity\Permission;
use Ds\Component\Database\Fixture\ResourceFixture;

/**
 * Class PermissionFixture
 *
 * @package Ds\Component\Security
 */
abstract class PermissionFixture extends ResourceFixture
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $objects = $this->parse($this->getResource());

        foreach ($objects as $object) {
            if (!is_array($object->key)) {
                $object->key = [$object->key];
            }

            foreach ($object->key as $key) {
                $permission = new Permission;
                $permission
                    ->setAccess($manager->getRepository(Access::class)->findOneBy(['uuid' => $object->access]))
                    ->setScope($object->scope)
                    ->setEntity($object->entity)
                    ->setEntityUuid($object->entity_uuid)
                    ->setKey($key)
                    ->setAttributes($object->attributes)
                    ->setTenant($object->tenant);
                $manager->persist($permission);
                $manager->flush();
            }
        }
    }
}
