<?php

namespace Ds\Component\Api\Service\Assets;

use Ds\Component\Api\Model\Assets\Asset;
use Ds\Component\Api\Query\Assets\AssetParameters as Parameters;
use Ds\Component\Api\Service\AbstractService;

/**
 * Class AssetService
 *
 * @package Ds\Component\Api
 */
class AssetService extends AbstractService
{
    /**
     * @const string
     */
    const MODEL = Asset::class;

    /**
     * @const string
     */
    const RESOURCE_LIST = '/assets';
    const RESOURCE_OBJECT = '/assets/{id}';

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
     * @param \Ds\Component\Api\Query\Assets\AssetParameters $parameters
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
