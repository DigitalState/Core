<?php

namespace Ds\Component\Security\Fixture\ORM;

use Ds\Component\Migration\Fixture\ORM\ResourceFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Ds\Component\Security\Entity\Access;

/**
 * Class AccessFixture
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
                ->setUuid($access['uuid'])
                ->setOwner($access['owner'])
                ->setOwnerUuid($access['owner_uuid'])
                ->setIdentity($access['identity'])
                ->setIdentityUuid($access['identity_uuid']);
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
