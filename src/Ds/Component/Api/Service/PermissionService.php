<?php

namespace Ds\Component\Api\Service;

use Ds\Component\Api\Model\Permission;
use Ds\Component\Api\Query\PermissionParameters as Parameters;

/**
 * Class PermissionService
 *
 * @package Ds\Component\Api
 */
class PermissionService extends AbstractService
{
    /**
     * @const string
     */
    const MODEL = Permission::class;

    /**
     * @const string
     */
    const RESOURCE_LIST = '/permissions';
    const RESOURCE_OBJECT = '/permissions/{id}';

    /**
     * @var array
     */
    protected static $map = [
        'id',
        'uuid',
        'createdAt',
        'updatedAt',
        'scope',
        'entity',
        'entityUuid',
        'key',
        'attributes'
    ];

    /**
     * Get permission list
     *
     * @param \Ds\Component\Api\Query\PermissionParameters $parameters
     * @return array
     */
    public function getList(Parameters $parameters = null)
    {
        $objects = $this->execute('GET', 'http://www.mocky.io/v2/592b798d100000b10e389778');
        $list = [];

        foreach ($objects as $object) {
            $model = static::toModel($object);
            $list[] = $model;
        }

        return $list;
    }
}
