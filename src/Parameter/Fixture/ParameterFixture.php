<?php

namespace Ds\Component\Parameter\Fixture;

use Doctrine\Common\Persistence\ObjectManager;
use Ds\Component\Parameter\Entity\Parameter;
use Ds\Component\Database\Fixture\ResourceFixture;

/**
 * Class ParameterFixture
 *
 * @package Ds\Component\Parameter
 */
abstract class ParameterFixture extends ResourceFixture
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
                $connection->exec('ALTER SEQUENCE ds_parameter_id_seq RESTART WITH 1');
                break;
        }

        $objects = $this->parse($this->getResource());

        foreach ($objects as $object) {
            $parameter = new Parameter;
            $parameter
                ->setKey($object->key)
                ->setValue($object->value);
            $manager->persist($parameter);
            $manager->flush();
            $manager->detach($parameter);
        }
    }
}
