<?php

namespace Ds\Component\Api\Service;

use Ds\Component\Api\Model\Record;
use Ds\Component\Api\Query\RecordParameters as Parameters;

/**
 * Class RecordService
 *
 * @package Ds\Component\Api
 */
final class RecordService implements Service
{
    use Base;

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
    private static $map = [
        'id',
        'uuid'
    ];

    /**
     * Get record list
     *
     * @param \Ds\Component\Api\Query\RecordParameters $parameters
     * @return array
     */
    public function getList(Parameters $parameters = null): array
    {
        $objects = $this->execute('GET', static::RESOURCE_LIST);
        $list = [];

        foreach ($objects as $object) {
            $model = static::toModel($object);
            $list[] = $model;
        }

        return $list;
    }
}
