<?php

namespace Ds\Component\Api\Service;

use Ds\Component\Api\Model\BusinessUnit;
use Ds\Component\Api\Query\BusinessUnitParameters as Parameters;

/**
 * Class BusinessUnitService
 *
 * @package Ds\Component\Api
 */
final class BusinessUnitService implements Service
{
    use Base;

    /**
     * @const string
     */
    const MODEL = BusinessUnit::class;

    /**
     * @const string
     */
    const RESOURCE_LIST = '/business_units';
    const RESOURCE_OBJECT = '/business_units/{id}';

    /**
     * @var array
     */
    private static $map = [
        'id',
        'uuid'
    ];

    /**
     * Get business unit list
     *
     * @param \Ds\Component\Api\Query\BusinessUnitParameters $parameters
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
}
