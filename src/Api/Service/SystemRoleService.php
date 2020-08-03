<?php

namespace Ds\Component\Api\Service;

use Ds\Component\Api\Model\SystemRole;
use Ds\Component\Api\Query\SystemRoleParameters as Parameters;

/**
 * Class SystemRoleService
 *
 * @package Ds\Component\Api
 */
final class SystemRoleService implements Service
{
    use Base;

    /**
     * @const string
     */
    const MODEL = SystemRole::class;

    /**
     * @const string
     */
    const RESOURCE_LIST = '/system_roles';

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
        'system',
        'role',
        'entityUuids',
        'version',
        'tenant'
    ];

    /**
     * Get system role list
     *
     * @param \Ds\Component\Api\Query\SystemRoleParameters $parameters
     * @return array
     */
    public function getList(Parameters $parameters = null): array
    {
        $options = [];

        if ($parameters) {
            $options['query'] = (array) $parameters->toObject(true);

            if (array_key_exists('systemUuid', $options['query'])) {
                $options['query']['system.uuid'] = $options['query']['systemUuid'];
                unset($options['query']['systemUuid']);
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
