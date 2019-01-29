<?php

namespace Ds\Component\Api\Service;

use Ds\Component\Api\Model\Data;
use Ds\Component\Api\Query\DataParameters as Parameters;

/**
 * Class DataService
 *
 * @package Ds\Component\Api
 */
final class DataService implements Service
{
    use Base;

    /**
     * @const string
     */
    const MODEL = Data::class;

    /**
     * @const string
     */
    const RESOURCE_LIST = '/datas';
    const RESOURCE_OBJECT = '/datas/{id}';

    /**
     * @var array
     */
    private static $map = [
        'id',
        'uuid'
    ];

    /**
     * Get data list
     *
     * @param \Ds\Component\Api\Query\DataParameters $parameters
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
