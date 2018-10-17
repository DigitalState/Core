<?php

namespace Ds\Component\Api\Service;

use Ds\Component\Api\Model\CaseStatus;
use Ds\Component\Api\Query\CaseStatusParameters as Parameters;

/**
 * Class CaseStatusService
 *
 * @package Ds\Component\Api
 */
class CaseStatusService extends AbstractService
{
    /**
     * @const string
     */
    const MODEL = CaseStatus::class;

    /**
     * @const string
     */
    const RESOURCE_LIST = '/case-statuses';
    const RESOURCE_OBJECT = '/case-statuses/{id}';

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
     * @param \Ds\Component\Api\Query\CaseStatusParameters $parameters
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
