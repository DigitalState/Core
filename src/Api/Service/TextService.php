<?php

namespace Ds\Component\Api\Service;

use Ds\Component\Api\Model\Text;
use Ds\Component\Api\Query\TextParameters as Parameters;

/**
 * Class TextService
 *
 * @package Ds\Component\Api
 */
final class TextService implements Service
{
    use Base;

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
    private static $map = [
        'id',
        'uuid'
    ];

    /**
     * Get text list
     *
     * @param \Ds\Component\Api\Query\TextParameters $parameters
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
