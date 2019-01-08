<?php

namespace Ds\Component\Config\Tenant\Loader;

use Ds\Component\Database\Util\Objects;
use Ds\Component\Tenant\Entity\Tenant;

/**
 * Trait Config
 *
 * @package Ds\Component\Config
 */
trait Config
{
    /**
     * @var \Ds\Component\Config\Service\ConfigService
     */
    private $configService;

    /**
     * @var string
     */
    private $path;

    /**
     * {@inheritdoc}
     */
    public function load(Tenant $tenant)
    {
        $data = (array) json_decode(json_encode($tenant->getData()));
        $objects = Objects::parseFile($this->path, $data);
        $manager = $this->configService->getManager();

        foreach ($objects as $object) {
            $config = $this->configService->createInstance();
            $config
                ->setOwner($object->owner)
                ->setOwnerUuid($object->owner_uuid)
                ->setKey($object->key)
                ->setValue($object->value)
                ->setTenant($object->tenant);
            $manager->persist($config);
            $manager->flush();
            $manager->detach($config);
        }
    }
}
