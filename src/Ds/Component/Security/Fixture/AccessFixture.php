<?php

namespace Ds\Component\Security\Fixture;

use Doctrine\Common\Persistence\ObjectManager;
use Ds\Component\Security\Entity\Access;
use Ds\Component\Database\Fixture\ResourceFixture;

/**
 * Class AccessFixture
 *
 * @package Ds\Component\Security
 */
abstract class AccessFixture extends ResourceFixture
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
                $connection->exec('ALTER SEQUENCE ds_access_id_seq RESTART WITH 1');
                break;
        }

        $objects = $this->parse($this->getResource());

        foreach ($objects as $object) {
            $access = new Access;
            $access
                ->setUuid($object->uuid)
                ->setOwner($object->owner)
                ->setOwnerUuid($object->owner_uuid)
                ->setAssignee($object->assignee)
                ->setAssigneeUuid($object->assignee_uuid)
                ->setTenant($object->tenant);
            $manager->persist($access);
            $manager->flush();
        }
    }
}
