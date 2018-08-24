<?php

namespace Ds\Component\Camunda\Fixture\Camunda;

use Doctrine\Common\Persistence\ObjectManager;
use Ds\Component\Camunda\Model\Tenant;
use Ds\Component\Camunda\Query\TenantParameters;
use Ds\Component\Database\Fixture\ResourceFixture;

/**
 * Class TenantFixture
 *
 * @package Ds\Component\Camunda
 */
abstract class TenantFixture extends ResourceFixture
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        // @todo remove dependency on ds_api, add camunda api services
        $app = $this->container->getParameter('app');
        $env = $this->container->get('kernel')->getEnvironment();

        // @todo create mock server instead of skipping fixture
        if ('test' === $env) {
            return;
        }

        $api = $this->container->get('ds_api.api')->get('camunda.tenant');
        $parameters = new TenantParameters;
        $tenants = $api->getList($parameters);

        foreach ($tenants as $tenant) {
            $parameters = new TenantParameters;
            $api->delete($tenant->getId(), $parameters);
        }

        $objects = $this->parse($this->getResource());

        foreach ($objects as $object) {
            $tenant = new Tenant;
            $tenant->setName($object->name);
            $api->create($tenant);
        }
    }
}
