<?php

namespace Ds\Component\Config\Fixture;

use Doctrine\Common\Persistence\ObjectManager;
use Ds\Component\Config\Entity\Parameter;
use Ds\Component\Database\Fixture\ResourceFixture;

/**
 * Class ParameterFixture
 *
 * @package Ds\Component\Config
 */
abstract class ParameterFixture extends ResourceFixture
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $objects = $this->parse($this->getResource());

        foreach ($objects as $object) {
            $parameter = new Parameter;
            $parameter
                ->setKey($object->key)
                ->setValue($object->value)
                ->setEnabled($object->enabled);
            $manager->persist($parameter);
            $manager->flush();
        }
    }
}
