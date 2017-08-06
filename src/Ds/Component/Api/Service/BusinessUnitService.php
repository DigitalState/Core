<?php

namespace Ds\Component\Api\Service;

use Ds\Component\Api\Model\BusinessUnit;
use Ds\Component\Api\Query\BusinessUnitParameters as Parameters;

/**
 * Class BusinessUnitService
 *
 * @package Ds\Component\Api
 */
class BusinessUnitService extends AbstractService
{
    /**
     * @const string
     */
    const MODEL = BusinessUnit::class;

    /**
     * @const string
     */
    const RESOURCE_LIST = '/business-units';
    const RESOURCE_OBJECT = '/business-units/{id}';

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
     * @param \Ds\Component\Api\Query\BusinessUnitParameters $parameters
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
