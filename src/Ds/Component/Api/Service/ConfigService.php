<?php

namespace Ds\Component\Api\Service;

use Ds\Component\Api\Model\Config;
use Ds\Component\Api\Query\ConfigParameters as Parameters;

/**
 * Class ConfigService
 *
 * @package Ds\Component\Api
 */
class ConfigService extends AbstractService
{
    /**
     * @const string
     */
    const MODEL = Config::class;

    /**
     * @const string
     */
    const RESOURCE_LIST = '/configs';
    const RESOURCE_OBJECT = '/configs/{id}';

    /**
     * @var array
     */
    protected static $map = [
        'id',
        'uuid'
    ];

    /**
     * Get config list
     *
     * @param \Ds\Component\Api\Query\ConfigParameters $parameters
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
