<?php

namespace Ds\Component\Config\Fixture;

use Doctrine\Common\Persistence\ObjectManager;
use Ds\Component\Config\Entity\Config;
use Ds\Component\Database\Fixture\ResourceFixture;

/**
 * Class ConfigFixture
 *
 * @package Ds\Component\Config
 */
abstract class ConfigFixture extends ResourceFixture
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
                $connection->exec('ALTER SEQUENCE ds_config_id_seq RESTART WITH 1');
                break;
        }

        $objects = $this->parse($this->getResource());

        foreach ($objects as $object) {
            $config = new Config;
            $config
                ->setUuid($object->uuid)
                ->setOwner($object->owner)
                ->setOwnerUuid($object->owner_uuid)
                ->setKey($object->key)
                ->setValue($object->value)
                ->setEncrypted($object->encrypted)
                ->setEnabled($object->enabled)
                ->setTenant($object->tenant);
            $manager->persist($config);
            $manager->flush();
        }
    }
}
