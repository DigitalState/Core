<?php

namespace Ds\Component\Acl\Fixture;

use DateTime;
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

            if (null !== $object->created_at) {
                $date = new DateTime;
                $date->setTimestamp($object->created_at);
                $access->setCreatedAt($date);
            }

            $manager->persist($access);
        }

        $manager->flush();
    }
}
