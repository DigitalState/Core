<?php

namespace Ds\Component\Api\Service;

use Ds\Component\Api\Model\CaseModel;
use Ds\Component\Api\Query\CaseParameters as Parameters;

/**
 * Class CaseService
 *
 * @package Ds\Component\Api
 */
class CaseService extends AbstractService
{
    /**
     * @const string
     */
    const MODEL = CaseModel::class;

    /**
     * @const string
     */
    const RESOURCE_LIST = '/cases';
    const RESOURCE_OBJECT = '/cases/{id}';

    /**
     * @var array
     */
    protected static $map = [
        'id',
        'uuid'
    ];

    /**
     * Get asset list
     *
     * @param \Ds\Component\Api\Query\CaseParameters $parameters
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
