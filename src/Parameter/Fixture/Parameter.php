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
        $connection = $manager->getConnection();
        $platform = $connection->getDatabasePlatform()->getName();

        switch ($platform) {
            case 'postgresql':
                $connection->exec('ALTER SEQUENCE ds_parameter_id_seq RESTART WITH 1');
                break;
        }

        $objects = $this->parse($this->path);

        foreach ($objects as $object) {
            $parameter = new ParameterEntity;
            $parameter
                ->setKey($object->key)
                ->setValue($object->value);
            $manager->persist($parameter);
            $manager->flush();
            $manager->detach($parameter);
        }
    }
}
