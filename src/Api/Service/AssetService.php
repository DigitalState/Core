<?php

namespace Ds\Component\Api\Service;

use Ds\Component\Api\Model\Asset;
use Ds\Component\Api\Query\AssetParameters as Parameters;

/**
 * Class AssetService
 *
 * @package Ds\Component\Api
 */
final class AssetService implements Service
{
    use Base;

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
    private static $map = [
        'id',
        'uuid'
    ];

    /**
     * Get asset list
     *
     * @param \Ds\Component\Api\Query\AssetParameters $parameters
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
