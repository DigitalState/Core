<?php

namespace Ds\Component\Api\Service;

use Ds\Component\Api\Model\CaseStatus;
use Ds\Component\Api\Query\CaseStatusParameters as Parameters;

/**
 * Class CaseStatusService
 *
 * @package Ds\Component\Api
 */
final class CaseStatusService implements Service
{
    use Base;

    /**
     * @const string
     */
    const MODEL = CaseStatus::class;

    /**
     * @const string
     */
    const RESOURCE_LIST = '/case_statuses';
    const RESOURCE_OBJECT = '/case_statuses/{id}';

    /**
     * @var array
     */
    private static $map = [
        'id',
        'uuid'
    ];

    /**
     * Get asset list
     *
     * @param \Ds\Component\Api\Query\CaseStatusParameters $parameters
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
