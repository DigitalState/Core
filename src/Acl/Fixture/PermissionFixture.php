<?php

namespace Ds\Component\Acl\Fixture;

use Doctrine\Common\Persistence\ObjectManager;
use Ds\Component\Acl\Entity\Access;
use Ds\Component\Acl\Entity\Permission;
use Ds\Component\Database\Fixture\ResourceFixture;

/**
 * Class PermissionFixture
 *
 * @package Ds\Component\Acl
 */
abstract class PermissionFixture extends ResourceFixture
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $connection = $manager->getConnection();
        $platform = $connection->getDatabasePlatform()->getName();

        switch ($platform) {
            case 'postgresql':
                $connection->exec('ALTER SEQUENCE ds_access_permission_id_seq RESTART WITH 1');
                break;
        }

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
                $manager->detach($permission);
            }
        }
    }
}
