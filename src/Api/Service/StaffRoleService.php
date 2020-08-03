<?php

namespace Ds\Component\Api\Service;

use Ds\Component\Api\Model\StaffRole;
use Ds\Component\Api\Query\StaffRoleParameters as Parameters;

/**
 * Class StaffRoleService
 *
 * @package Ds\Component\Api
 */
final class StaffRoleService implements Service
{
    use Base;

    /**
     * @const string
     */
    const MODEL = StaffRole::class;

    /**
     * @const string
     */
    const RESOURCE_LIST = '/staff_roles';

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
        'staff',
        'role',
        'entityUuids',
        'version',
        'tenant'
    ];

    /**
     * Get staff role list
     *
     * @param \Ds\Component\Api\Query\StaffRoleParameters $parameters
     * @return array
     */
    public function getList(Parameters $parameters = null): array
    {
        $options = [];

        if ($parameters) {
            $options['query'] = (array) $parameters->toObject(true);

            if (array_key_exists('staffUuid', $options['query'])) {
                $options['query']['staff.uuid'] = $options['query']['staffUuid'];
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
