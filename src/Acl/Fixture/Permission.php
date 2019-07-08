<?php

namespace Ds\Component\Acl\Fixture;

use Doctrine\Common\Persistence\ObjectManager;
use Ds\Component\Acl\Entity\Access;
use Ds\Component\Acl\Entity\Permission as PermissionEntity;
use Ds\Component\Acl\Entity\Scope;
use Ds\Component\Database\Fixture\Yaml;
use LogicException;

/**
 * Trait Permission
 *
 * @package Ds\Component\Acl
 */
trait Permission
{
    use Yaml;

    /**
     * @var string
     */
    private $path;

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $objects = $this->parse($this->path);

        foreach ($objects as $object) {
            if (!is_array($object->key)) {
                $object->key = [$object->key];
            }

            foreach ($object->key as $key) {
                $access = $manager->getRepository(Access::class)->findOneBy(['uuid' => $object->access]);

                if (!$access) {
                    throw new LogicException('Access "'.$object->access.'" does not exist.');
                }

                $scope = new Scope;
                $scope
                    ->setType($object->scope->type ?? null)
                    ->setEntity($object->scope->entity ?? null)
                    ->setEntityUuid($object->scope->entity_uuid ?? null);
                $permission = new PermissionEntity;
                $permission
                    ->setAccess($access)
                    ->setScope($scope)
                    ->setKey($key)
                    ->setAttributes($object->attributes)
                    ->setTenant($object->tenant);
                $manager->persist($permission);
            }
        }

        $manager->flush();
    }
}
