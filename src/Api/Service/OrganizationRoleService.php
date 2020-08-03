<?php

namespace Ds\Component\Api\Service;

use Ds\Component\Api\Model\OrganizationRole;
use Ds\Component\Api\Query\OrganizationRoleParameters as Parameters;

/**
 * Class OrganizationRoleService
 *
 * @package Ds\Component\Api
 */
final class OrganizationRoleService implements Service
{
    use Base;

    /**
     * @const string
     */
    const MODEL = OrganizationRole::class;

    /**
     * @const string
     */
    const RESOURCE_LIST = '/organization_roles';

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
        'organization',
        'role',
        'entityUuids',
        'version',
        'tenant'
    ];

    /**
     * Get organization role list
     *
     * @param \Ds\Component\Api\Query\OrganizationRoleParameters $parameters
     * @return array
     */
    public function getList(Parameters $parameters = null): array
    {
        $options = [];

        if ($parameters) {
            $options['query'] = (array) $parameters->toObject(true);

            if (array_key_exists('organizationUuid', $options['query'])) {
                $options['query']['organization.uuid'] = $options['query']['organizationUuid'];
                unset($options['query']['organizationUuid']);
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
