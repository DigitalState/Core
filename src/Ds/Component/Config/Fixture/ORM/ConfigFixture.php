<?php

namespace Ds\Component\Config\Fixture\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Ds\Component\Config\Entity\Config;
use Ds\Component\Database\Fixture\ORM\ResourceFixture;

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
                ->setUuid($config['uuid'])
                ->setOwner($config['owner'])
                ->setOwnerUuid($config['owner_uuid'])
                ->setKey($config['key'])
                ->setValue($config['value'])
                ->setEnabled($config['enabled']);
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
