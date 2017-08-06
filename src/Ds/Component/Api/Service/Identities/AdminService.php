<?php

namespace Ds\Component\Api\Service\Identities;

use Ds\Component\Api\Model\Identities\Admin;
use Ds\Component\Api\Query\Identities\AdminParameters as Parameters;
use Ds\Component\Api\Service\AbstractService;

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
     * @param \Ds\Component\Api\Query\Identities\AdminParameters $parameters
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
