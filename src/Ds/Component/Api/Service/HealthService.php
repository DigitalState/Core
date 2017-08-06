<?php

namespace Ds\Component\Api\Service;

use Ds\Component\Api\Model\Health;
use Ds\Component\Api\Query\HealthParameters as Parameters;

/**
 * Class HealthService
 *
 * @package Ds\Component\Api
 */
class HealthService extends AbstractService
{
    /**
     * @const string
     */
    const MODEL = Health::class;

    /**
     * @const string
     */
    const RESOURCE_LIST = '/health';
    const RESOURCE_OBJECT = '/health/{id}';

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
     * @param \Ds\Component\Api\Query\HealthParameters $parameters
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
