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
class StaffService extends AbstractService
{
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
    protected static $map = [
        'id',
        'uuid'
    ];

    /**
     * Get staff list
     *
     * @param \Ds\Component\Api\Query\StaffParameters $parameters
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
     * Get staff
     *
     * @param string $id
     * @param \Ds\Component\Api\Query\StaffParameters $parameters
     * @return \Ds\Component\Api\Model\Staff
     */
    public function get($id, Parameters $parameters = null)
    {
        $resource = str_replace('{id}', $id, static::RESOURCE_OBJECT);
        $object = $this->execute('GET', $resource);
        $model = static::toModel($object);

        return $model;
    }
}
