<?php

namespace Ds\Component\Acl\Fixture;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class PermissionSequenceFixture
 *
 * @package Ds\Component\Acl
 */
final class PermissionSequenceFixture implements FixtureInterface, OrderedFixtureInterface
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
                $connection->exec('ALTER SEQUENCE ds_access_permission_id_seq RESTART WITH 1');
                break;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return -10;
    }
}
