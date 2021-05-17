<?php

namespace Ds\Component\Metadata\Fixture;

use DateTime;
use Doctrine\Common\Persistence\ObjectManager;
use Ds\Component\Database\Fixture\Yaml;
use Ds\Component\Metadata\Entity\Metadata as MetadataEntity;

/**
 * Trait Metadata
 *
 * @package Ds\Component\Metadata
 */
trait Metadata
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
            $metadata = new MetadataEntity;
            $metadata
                ->setUuid($object->uuid)
                ->setOwner($object->owner)
                ->setOwnerUuid($object->owner_uuid)
                ->setTitle((array) $object->title)
                ->setSlug($object->slug)
                ->setType($object->type)
                ->setData((array) $object->data)
                ->setTenant($object->tenant);

            if (null !== $object->created_at) {
                $date = new DateTime;
                $date->setTimestamp($object->created_at);
                $metadata->setCreatedAt($date);
            }

            $manager->persist($metadata);
        }

        $manager->flush();
    }
}
