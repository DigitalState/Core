<?php

namespace Ds\Component\Metadata\Fixture;

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
        $connection = $manager->getConnection();
        $platform = $connection->getDatabasePlatform()->getName();

        switch ($platform) {
            case 'postgresql':
                $connection->exec('ALTER SEQUENCE ds_metadata_id_seq RESTART WITH 1');
                $connection->exec('ALTER SEQUENCE ds_metadata_trans_id_seq RESTART WITH 1');
                break;
        }

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
            $manager->persist($metadata);
        }

        $manager->flush();
    }
}
