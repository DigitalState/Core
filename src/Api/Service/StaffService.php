<?php

namespace Ds\Component\Api\Service;

use Ds\Component\Api\Model\Staff;
use Ds\Component\Api\Query\StaffParameters as Parameters;
use Ds\Component\Api\Service\AbstractService;

/**
 * Class StaffService
 *
 * @package Ds\Component\Api
 */
class StaffService implements Service
{
    use Base;

    /**
     * @const string
     */
    const MODEL = Staff::class;

    /**
     * @const string
     */
    const RESOURCE_LIST = '/staffs';
    const RESOURCE_OBJECT = '/staffs/{id}';

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
        'roles',
        'businessUnits',
        'version',
        'tenant'
    ];

    /**
     * Get staff list
     *
     * @param \Ds\Component\Api\Query\StaffParameters $parameters
     * @return array
     */
    public function getList(Parameters $parameters = null): array
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
     * Get staff
     *
     * @param string $id
     * @param \Ds\Component\Api\Query\StaffParameters $parameters
     * @return \Ds\Component\Api\Model\Staff
     */
    public function get($id, Parameters $parameters = null): Staff
    {
        $resource = str_replace('{id}', $id, static::RESOURCE_OBJECT);
        $object = $this->execute('GET', $resource);
        /** @var \Ds\Component\Api\Model\Staff $model */
        $model = static::toModel($object);

        return $model;
    }
}
