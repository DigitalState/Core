<?php

namespace Ds\Component\System\Service;

use Ds\Component\System\Model\Tenant;
use Ds\Component\System\Query\TenantParameters as Parameters;

/**
 * Class TenantService
 *
 * @package Ds\Component\System
 */
class TenantService implements Service
{
    use Base;

    /**
     * @const string
     */
    const MODEL = Tenant::class;

    /**
     * @const string
     */
    const RESOURCE_LIST = '/system/tenants';
    const RESOURCE_OBJECT = '/system/tenants/{id}';

    /**
     * @var array
     */
    private static $map = [
        'id',
        'uuid',
        'createdAt',
        'updatedAt',
        'data',
        'version'
    ];

    /**
     * Get tenant list
     *
     * @param \Ds\Component\System\Query\TenantParameters $parameters
     * @return array
     */
    public function getList(Parameters $parameters = null): array
    {
        $objects = $this->execute('GET', static::RESOURCE_LIST);
        $list = [];

        foreach ($objects as $object) {
            $model = static::toModel($object);
            $list[] = $model;
        }

        return $list;
    }

    /**
     * Get tenant
     *
     * @param string $id
     * @param \Ds\Component\System\Query\TenantParameters $parameters
     * @return \Ds\Component\System\Model\Tenant
     */
    public function get($id, Parameters $parameters = null)
    {
        $resource = str_replace('{id}', $id, static::RESOURCE_OBJECT);
        $object = $this->execute('GET', $resource);
        $model = static::toModel($object);

        return $model;
    }

    /**
     * Create tenant
     *
     * @param \Ds\Component\System\Model\Tenant $tenant
     * @param \Ds\Component\System\Query\TenantParameters $parameters
     * @return \Ds\Component\System\Model\Tenant
     */
    public function create(Tenant $tenant, Parameters $parameters = null)
    {
        $options = [];
        $options['json'] = (array) static::toObject($tenant);

        if ($parameters) {
            $options['query'] = (array) $parameters->toObject(true);
        }

        $object = $this->execute('POST', static::RESOURCE_LIST, $options);
        $tenant = static::toModel($object);

        return $tenant;
    }

    /**
     * Delete tenant
     *
     * @param string $id
     * @param \Ds\Component\System\Query\TenantParameters $parameters
     * @return \Ds\Component\System\Model\Tenant
     */
    public function delete($id, Parameters $parameters = null)
    {
        $options = [];

        if ($parameters) {
            $options['query'] = (array) $parameters->toObject(true);
        }

        $resource = str_replace('{id}', $id, static::RESOURCE_OBJECT);
        $this->execute('DELETE', $resource, $options);

        return $this;
    }
}
