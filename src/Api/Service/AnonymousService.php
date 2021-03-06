<?php

namespace Ds\Component\Api\Service;

use Ds\Component\Api\Model\Anonymous;
use Ds\Component\Api\Query\AnonymousParameters as Parameters;

/**
 * Class AnonymousService
 *
 * @package Ds\Component\Api
 */
final class AnonymousService implements Service
{
    use Base;

    /**
     * @const string
     */
    const MODEL = Anonymous::class;

    /**
     * @const string
     */
    const RESOURCE_LIST = '/anonymouses';
    const RESOURCE_OBJECT = '/anonymouses/{id}';

    /**
     * @var array
     */
    private static $map = [
        'id',
        'uuid',
        'createdAt',
        'updatedAt',
        'owner',
        'ownerUuid',
        'roles',
        'version',
        'tenant'
    ];

    /**
     * Get anonymous list
     *
     * @param \Ds\Component\Api\Query\AnonymousParameters $parameters
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

    /**
     * Get anonymous
     *
     * @param string $id
     * @param \Ds\Component\Api\Query\AnonymousParameters $parameters
     * @return \Ds\Component\Api\Model\Anonymous
     */
    public function get($id, Parameters $parameters = null): Anonymous
    {
        $resource = str_replace('{id}', $id, static::RESOURCE_OBJECT);
        $object = $this->execute('GET', $resource);
        /** @var \Ds\Component\Api\Model\Anonymous $model */
        $model = static::toModel($object);

        return $model;
    }
}
