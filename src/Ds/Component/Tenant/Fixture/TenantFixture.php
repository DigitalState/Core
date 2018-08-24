<?php

namespace Ds\Component\Tenant\Fixture;

use Doctrine\Common\Persistence\ObjectManager;
use Ds\Component\Tenant\Entity\Tenant;
use Ds\Component\Database\Fixture\ResourceFixture;
use Ds\Component\Tenant\EventListener\Entity\TenantListener;

/**
 * Class TenantFixture
 *
 * @package Ds\Component\Tenant
 */
abstract class TenantFixture extends ResourceFixture
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        // Disable the event listener in charge of loading tenant data
        $metadata = $manager->getClassMetadata(Tenant::class);

        foreach ($metadata->entityListeners as $event => $listeners) {
            foreach ($listeners as $key => $listener) {
                if (TenantListener::class === $listener['class']) {
                    unset($metadata->entityListeners[$event][$key]);
                }
            }
        }

        $connection = $manager->getConnection();
        $platform = $connection->getDatabasePlatform()->getName();

        switch ($platform) {
            case 'postgresql':
                $connection->exec('ALTER SEQUENCE ds_tenant_id_seq RESTART WITH 1');
                break;
        }

        $objects = $this->parse($this->getResource());

        foreach ($objects as $object) {
            $tenant = new Tenant;
            $tenant
                ->setUuid($object->uuid)
                ->setData((array) $object->data);
            $manager->persist($tenant);
            $manager->flush();
        }
    }
}
