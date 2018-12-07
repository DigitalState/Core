<?php

namespace Ds\Component\Config\Fixture;

use Doctrine\Common\Persistence\ObjectManager;
use Ds\Component\Config\Entity\Config as ConfigEntity;
use Ds\Component\Database\Fixture\Yaml;

/**
 * Trait Config
 *
 * @package Ds\Component\Config
 */
trait Config
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
                $connection->exec('ALTER SEQUENCE ds_config_id_seq RESTART WITH 1');
                break;
        }

        $objects = $this->parse($this->path);

        foreach ($objects as $object) {
            $config = new ConfigEntity;
            $config
                ->setUuid($object->uuid)
                ->setOwner($object->owner)
                ->setOwnerUuid($object->owner_uuid)
                ->setKey($object->key)
                ->setValue($object->value)
                ->setTenant($object->tenant);
            $manager->persist($config);
        }

        $manager->flush();
    }
}
