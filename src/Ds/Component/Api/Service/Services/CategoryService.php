<?php

namespace Ds\Component\Api\Service\Services;

use Ds\Component\Api\Model\Services\Category;
use Ds\Component\Api\Query\Services\CategoryParameters as Parameters;
use Ds\Component\Api\Service\AbstractService;

/**
 * Class CategoryService
 *
 * @package Ds\Component\Api
 */
class CategoryService extends AbstractService
{
    /**
     * @const string
     */
    const MODEL = Category::class;

    /**
     * @const string
     */
    const RESOURCE_LIST = '/categories';
    const RESOURCE_OBJECT = '/categories/{id}';

    /**
     * @var array
     */
    protected static $map = [
        'id',
        'uuid'
    ];

    /**
     * Get category list
     *
     * @param \Ds\Component\Api\Query\Services\CategoryParameters $parameters
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
