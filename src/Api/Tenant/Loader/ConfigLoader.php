<?php

namespace Ds\Component\Api\Tenant\Loader;

use Ds\Component\Config\Service\ConfigService;
use Ds\Component\Tenant\Entity\Tenant;
use Ds\Component\Tenant\Loader\Loader;
use Symfony\Component\Yaml\Yaml;

/**
 * Class ConfigLoader
 *
 * @package Ds\Component\Api
 */
class ConfigLoader implements Loader
{
    /**
     * @var \Ds\Component\Config\Service\ConfigService
     */
    protected $configService;

    /**
     * Constructor
     *
     * @param \Ds\Component\Config\Service\ConfigService $configService
     */
    public function __construct(ConfigService $configService)
    {
        $this->configService = $configService;
    }

    /**
     * {@inheritdoc}
     */
    public function load(Tenant $tenant)
    {
        $yml = file_get_contents('/srv/api-platform/vendor/digitalstate/core/src/Ds/Component/Api/Resources/tenant/configs.yml');

        // @todo Figure out how symfony does parameter binding and use the same technique
        $yml = strtr($yml, [
            '%user.system.password%' => $tenant->getData()['user']['system']['password'],
            '%user.system.uuid%' => $tenant->getData()['user']['system']['uuid'],
            '%identity.system.uuid%' => $tenant->getData()['identity']['system']['uuid'],
            '%business_unit.administration.uuid%' => $tenant->getData()['business_unit']['administration']['uuid'],
            '%tenant.uuid%' => $tenant->getUuid()
        ]);

        $configs = Yaml::parse($yml, YAML::PARSE_OBJECT_FOR_MAP);
        $manager = $this->configService->getManager();

        foreach ($configs->objects as $object) {
            $object = (object) array_merge((array) $configs->prototype, (array) $object);
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
