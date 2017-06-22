<?php

namespace Ds\Component\Security\Fixture\ORM;

use Ds\Component\Migration\Fixture\ORM\ResourceFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Ds\Component\Security\Entity\PermissionEntry;
use Ds\Component\Security\Entity\Permission;

/**
 * Class PermissionEntryFixture
 */
abstract class PermissionEntryFixture extends ResourceFixture
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $entries = $this->parse($this->getResource());

        foreach ($entries as $entry) {
            $entity = new PermissionEntry;
            $entity
                ->setPermission($manager->getRepository(Permission::class)->findOneBy(['uuid' => $entry['permission']]))
                ->setBusinessUnitUuid($entry['business_unit_uuid'])
                ->setKey($entry['key'])
                ->setAttributes($entry['attributes']);
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
