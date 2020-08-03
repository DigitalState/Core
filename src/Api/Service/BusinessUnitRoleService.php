<?php

namespace Ds\Component\Api\Service;

use Ds\Component\Api\Model\BusinessUnitRole;
use Ds\Component\Api\Query\BusinessUnitRoleParameters as Parameters;

/**
 * Class BusinessUnitRoleService
 *
 * @package Ds\Component\Api
 */
final class BusinessUnitRoleService implements Service
{
    use Base;

    /**
     * @const string
     */
    const MODEL = BusinessUnitRole::class;

    /**
     * @const string
     */
    const RESOURCE_LIST = '/business_unit_roles';

    /**
     * @var array
     */
    private static $map = [
        'id',
        'uuid',
        'createdAt',
        'updatedAt',
        'owner',
        'ownerUuid',
        'businessUnit',
        'role',
        'entityUuids',
        'version',
        'tenant'
    ];

    /**
     * Get business unit role list
     *
     * @param \Ds\Component\Api\Query\BusinessUnitRoleParameters $parameters
     * @return array
     */
    public function getList(Parameters $parameters = null): array
    {
        $options = [];

        if ($parameters) {
            $options['query'] = (array) $parameters->toObject(true);

            if (array_key_exists('businessUnitUuid', $options['query'])) {
                $options['query']['businessUnit.uuid'] = $options['query']['businessUnitUuid'];
                unset($options['query']['businessUnitUuid']);
            }

            if (array_key_exists('staffUuid', $options['query'])) {
                $options['query']['businessUnit.staffs.uuid'] = $options['query']['staffUuid'];
                unset($options['query']['staffUuid']);
            }
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
