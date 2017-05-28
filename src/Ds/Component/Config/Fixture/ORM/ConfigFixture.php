<?php

namespace Ds\Component\Config\Fixture\ORM;

use Ds\Component\Migration\Fixture\ORM\ResourceFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Ds\Component\Config\Entity\Config;

/**
 * Class ConfigFixture
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
                ->setKey($config['key'])
                ->setValue($config['value'])
                ->setFallback($config['fallback']);
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
