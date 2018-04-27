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
        $configs = $this->parse($this->getResource());

        foreach ($configs as $config) {
            $entity = new Config;
            $entity
                ->setUuid($config->uuid)
                ->setOwner($config->owner)
                ->setOwnerUuid($config->owner_uuid)
                ->setKey($config->key)
                ->setValue($config->value)
                ->setEnabled($config->enabled);
            $manager->persist($entity);
            $manager->flush();
        }
    }
}
