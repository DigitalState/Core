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
        $accesses = $this->parse($this->getResource());

        foreach ($accesses as $access) {
            $entity = new Access;
            $entity
                ->setUuid($access->uuid)
                ->setOwner($access->owner)
                ->setOwnerUuid($access->owner_uuid)
                ->setAssignee($access->assignee)
                ->setAssigneeUuid($access->assignee_uuid)
                ->setTenant($access->tenant);
            $manager->persist($entity);
            $manager->flush();
        }
    }
}
