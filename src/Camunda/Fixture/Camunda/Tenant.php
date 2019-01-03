<?php

namespace Ds\Component\Camunda\Fixture;

use Doctrine\Common\Persistence\ObjectManager;
use Ds\Component\Api\Api\Api;
use Ds\Component\Camunda\Model\Tenant as TenantModel;
use Ds\Component\Camunda\Query\TenantParameters;
use Ds\Component\Database\Fixture\Yaml;

/**
 * Trait Tenant
 *
 * @package Ds\Component\Camunda
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
        if ('test' === $this->container->getParameter('kernel.environment')) {
            return;
        }

        $api = $this->container->get(Api::class)->get('workflow.tenant');
        $parameters = new TenantParameters;
        $tenants = $api->getList($parameters);

        foreach ($tenants as $tenant) {
            $parameters = new TenantParameters;
            $api->delete($tenant->getId(), $parameters);
        }

        $objects = $this->parse($this->path);

        foreach ($objects as $object) {
            $tenant = new TenantModel;
            $tenant->setName($object->name);
            $api->create($tenant);
        }
    }
}
