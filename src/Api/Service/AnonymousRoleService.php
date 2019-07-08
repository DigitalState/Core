<?php

namespace Ds\Component\Api\Service;

use Ds\Component\Api\Model\AnonymousRole;
use Ds\Component\Api\Query\AnonymousRoleParameters as Parameters;

/**
 * Class AnonymousRoleService
 *
 * @package Ds\Component\Api
 */
final class AnonymousRoleService implements Service
{
    use Base;

    /**
     * @const string
     */
    const MODEL = AnonymousRole::class;

    /**
     * @const string
     */
    const RESOURCE_LIST = '/anonymous_roles';

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
        'anonymous',
        'role',
        'businessUnits',
        'version',
        'tenant'
    ];

    /**
     * Get anonymous role list
     *
     * @param \Ds\Component\Api\Query\AnonymousRoleParameters $parameters
     * @return array
     */
    public function getList(Parameters $parameters = null): array
    {
        $options = [];

        if ($parameters) {
            $options['query'] = (array) $parameters->toObject(true);

            if (array_key_exists('anonymousUuid', $options['query'])) {
                $options['query']['anonymous.uuid'] = $options['query']['anonymousUuid'];
                unset($options['query']['anonymousUuid']);
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
