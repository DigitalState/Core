<?php

namespace Ds\Component\Parameter\Fixture;

use Doctrine\Common\Persistence\ObjectManager;
use Ds\Component\Database\Fixture\Yaml;
use Ds\Component\Parameter\Entity\Parameter as ParameterEntity;

/**
 * Trait Parameter
 *
 * @package Ds\Component\Parameter
 */
trait Parameter
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
            $parameter = new ParameterEntity;
            $parameter
                ->setKey($object->key)
                ->setValue($object->value);
            $manager->persist($parameter);
        }

        $manager->flush();
    }
}
