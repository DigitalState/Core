<?php

namespace Ds\Component\Api\Service;

use Ds\Component\Api\Model\Admin;
use Ds\Component\Api\Query\AdminParameters as Parameters;

/**
 * Class AdminService
 *
 * @package Ds\Component\Api
 */
class AdminService extends AbstractService
{
    /**
     * @const string
     */
    const MODEL = Admin::class;

    /**
     * @const string
     */
    const RESOURCE_LIST = '/admins';
    const RESOURCE_OBJECT = '/admins/{id}';

    /**
     * @var array
     */
    protected static $map = [
        'id',
        'uuid'
    ];

    /**
     * Get admin list
     *
     * @param \Ds\Component\Api\Query\AdminParameters $parameters
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
