<?php

namespace Ds\Component\Api\Service;

use Ds\Component\Api\Model\Record;
use Ds\Component\Api\Query\RecordParameters as Parameters;

/**
 * Class RecordService
 *
 * @package Ds\Component\Api
 */
class RecordService extends AbstractService
{
    /**
     * @const string
     */
    const MODEL = Record::class;

    /**
     * @const string
     */
    const RESOURCE_LIST = '/records';
    const RESOURCE_OBJECT = '/records/{id}';

    /**
     * @var array
     */
    protected static $map = [
        'id',
        'uuid'
    ];

    /**
     * Get record list
     *
     * @param \Ds\Component\Api\Query\RecordParameters $parameters
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
