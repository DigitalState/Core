<?php

namespace Ds\Component\Api\Service\Identities;

use Ds\Component\Api\Model\Identities\System;
use Ds\Component\Api\Query\Identities\SystemParameters as Parameters;
use Ds\Component\Api\Service\AbstractService;

/**
 * Class SystemService
 *
 * @package Ds\Component\Api
 */
class SystemService extends AbstractService
{
    /**
     * @const string
     */
    const MODEL = System::class;

    /**
     * @const string
     */
    const RESOURCE_LIST = '/systems';
    const RESOURCE_OBJECT = '/systems/{id}';

    /**
     * @var array
     */
    protected static $map = [
        'id',
        'uuid'
    ];

    /**
     * Get system list
     *
     * @param \Ds\Component\Api\Query\Identities\SystemParameters $parameters
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
