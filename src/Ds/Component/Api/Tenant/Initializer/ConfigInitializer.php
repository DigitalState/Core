<?php

namespace Ds\Component\Api\Tenant\Initializer;

use Ds\Component\Config\Service\ConfigService;
use Ds\Component\Tenant\Initializer\Initializer;

/**
 * Class ConfigInitializer
 *
 * @package Ds\Component\Api
 */
class ConfigInitializer implements Initializer
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
    public function initialize(array $data)
    {
        $items = [
            [
                'key' => 'ds_api.user.username',
                'value' => 'system@system.ds'
            ],
            [
                'key' => 'ds_api.user.password',
                'value' => $data['user']['system']['password']
            ],
            [
                'key' => 'ds_api.user.uuid',
                'value' => $data['user']['system']['uuid']
            ],
            [
                'key' => 'ds_api.user.roles',
                'value' => 'ROLE_SYSTEM'
            ],
            [
                'key' => 'ds_api.user.identity',
                'value' => 'System'
            ],
            [
                'key' => 'ds_api.user.identity_uuid',
                'value' => $data['identity']['system']['uuid']
            ]
        ];

        $manager = $this->configService->getManager();

        foreach ($items as $item) {
            $config = $this->configService->createInstance();
            $config
                ->setOwner('BusinessUnit')
                ->setOwnerUuid($data['business_unit']['administration']['uuid'])
                ->setKey($item['key'])
                ->setValue($item['value'])
                ->setTenant($data['tenant']['uuid']);
            $manager->persist($config);
            $manager->flush();
        }
    }
}
