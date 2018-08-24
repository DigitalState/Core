<?php

namespace Ds\Component\Api\Service;

use Ds\Component\Api\Model\System;
use Ds\Component\Api\Query\SystemParameters as Parameters;

/**
 * Class SystemService
 *
 * @package Ds\Component\Api
 */
class SystemService extends AbstractService
{
    /**
     * @const string
     */
    const MODEL = System::class;

    /**
     * @const string
     */
    const RESOURCE_LIST = '/systems';
    const RESOURCE_OBJECT = '/systems/{id}';

    /**
     * @var array
     */
    protected static $map = [
        'id',
        'uuid',
        'createdAt',
        'updatedAt',
        'owner',
        'ownerUuid',
        'roles',
        'version',
        'tenant'
    ];

    /**
     * Get system list
     *
     * @param \Ds\Component\Api\Query\SystemParameters $parameters
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

    /**
     * Get system
     *
     * @param string $id
     * @param \Ds\Component\Api\Query\SystemParameters $parameters
     * @return \Ds\Component\Api\Model\System
     */
    public function get($id, Parameters $parameters = null)
    {
        $resource = str_replace('{id}', $id, static::RESOURCE_OBJECT);
        $object = $this->execute('GET', $resource);
        $model = static::toModel($object);

        return $model;
    }
}
