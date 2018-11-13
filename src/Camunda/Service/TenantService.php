<?php

namespace Ds\Component\Camunda\Service;

use Ds\Component\Camunda\Model\Tenant;
use Ds\Component\Camunda\Query\TenantParameters as Parameters;

/**
 * Class TenantService
 *
 * @package Ds\Component\Camunda
 */
final class TenantService implements Service
{
    use Base;

    /**
     * @const string
     */
    const MODEL = Tenant::class;

    /**
     * @const string
     */
    const RESOURCE_LIST = '/engine-rest/tenant';

    /**
     * @var array
     */
    private static $map = [
        'id',
        'name'
    ];

    /**
     * Get list of tenants
     *
     * @param \Ds\Component\Camunda\Query\TenantParameters $parameters
     * @return array
     */
    public function getList(Parameters $parameters = null)
    {
        $options = [];

        if ($parameters) {
            $options['query'] = (array) $parameters->toObject(true);
        }

        $objects = $this->execute('GET', static::RESOURCE_LIST, $options);
        $list = [];

        foreach ($objects as $object) {
            $model = static::toModel($object);
            $list[] = $model;
        }

        return $list;
    }
}
