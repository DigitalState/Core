<?php

namespace Ds\Component\Metadata\Fixture;

use Doctrine\Common\Persistence\ObjectManager;
use Ds\Component\Metadata\Entity\Metadata;
use Ds\Component\Database\Fixture\ResourceFixture;

/**
 * Class MetadataFixture
 *
 * @package Ds\Component\Metadata
 */
abstract class MetadataFixture extends ResourceFixture
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $objects = $this->parse($this->getResource());

        foreach ($objects as $object) {
            $metadata = new Metadata;
            $metadata
                ->setUuid($object->uuid)
                ->setOwner($object->owner)
                ->setOwnerUuid($object->owner_uuid)
                ->setTitle((array) $object->title)
                ->setSlug($object->slug)
                ->setType($object->type)
                ->setData((array) $object->data)
                ->setTenant($object->tenant);
            $manager->persist($metadata);
            $manager->flush();
        }
    }
}
