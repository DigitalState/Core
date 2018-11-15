<?php

namespace Ds\Component\Acl\Fixture;

use Doctrine\Common\Persistence\ObjectManager;
use Ds\Component\Acl\Entity\Access as AccessEntity;
use Ds\Component\Database\Fixture\Yaml;

/**
 * Trait Access
 *
 * @package Ds\Component\Acl
 */
trait Access
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
        $connection = $manager->getConnection();
        $platform = $connection->getDatabasePlatform()->getName();

        switch ($platform) {
            case 'postgresql':
                $connection->exec('ALTER SEQUENCE ds_access_id_seq RESTART WITH 1');
                break;
        }

        $objects = $this->parse($this->path);

        foreach ($objects as $object) {
            $access = new AccessEntity;
            $access
                ->setUuid($object->uuid)
                ->setOwner($object->owner)
                ->setOwnerUuid($object->owner_uuid)
                ->setAssignee($object->assignee)
                ->setAssigneeUuid($object->assignee_uuid)
                ->setTenant($object->tenant);
            $manager->persist($access);
            $manager->flush();
            $manager->detach($access);
        }
    }
}
