<?php

namespace Ds\Component\Api\Service\Cms;

use Ds\Component\Api\Model\Cms\Text;
use Ds\Component\Api\Query\Cms\TextParameters as Parameters;
use Ds\Component\Api\Service\AbstractService;

/**
 * Class TextService
 *
 * @package Ds\Component\Api
 */
class TextService extends AbstractService
{
    /**
     * @const string
     */
    const MODEL = Text::class;

    /**
     * @const string
     */
    const RESOURCE_LIST = '/texts';
    const RESOURCE_OBJECT = '/texts/{id}';

    /**
     * @var array
     */
    protected static $map = [
        'id',
        'uuid'
    ];

    /**
     * Get text list
     *
     * @param \Ds\Component\Api\Query\Cms\TextParameters $parameters
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
