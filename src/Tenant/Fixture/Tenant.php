<?php

namespace Ds\Component\Tenant\Fixture;

use DateTime;
use Doctrine\Common\Persistence\ObjectManager;
use Ds\Component\Database\Fixture\Yaml;
use Ds\Component\Tenant\Entity\Tenant as TenantEntity;
use Ds\Component\Tenant\EventListener\LoaderListener;

/**
 * Class TenantFixture
 *
 * @package Ds\Component\Tenant
 */
trait Tenant
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
        // Disable the event listener in charge of loading tenant data
        $metadata = $manager->getClassMetadata(TenantEntity::class);

        foreach ($metadata->entityListeners as $event => $listeners) {
            foreach ($listeners as $key => $listener) {
                if (LoaderListener::class === $listener['class']) {
                    unset($metadata->entityListeners[$event][$key]);
                }
            }
        }

        $objects = $this->parse($this->path);

        foreach ($objects as $object) {
            $tenant = new TenantEntity;
            $tenant
                ->setUuid($object->uuid)
                ->setData((array) $object->data);

            if (null !== $object->created_at) {
                $date = new DateTime;
                $date->setTimestamp($object->created_at);
                $tenant->setCreatedAt($date);
            }

            $manager->persist($tenant);
        }

        $manager->flush();
    }
}
