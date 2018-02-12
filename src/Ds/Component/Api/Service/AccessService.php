<?php

namespace Ds\Component\Api\Service;

use Ds\Component\Api\Model\Access;
use Ds\Component\Api\Query\AccessParameters as Parameters;

/**
 * Class AccessService
 *
 * @package Ds\Component\Api
 */
class AccessService extends AbstractService
{
    /**
     * @const string
     */
    const MODEL = Access::class;

    /**
     * @const string
     */
    const RESOURCE_LIST = '/accesses';
    const RESOURCE_OBJECT = '/accesses/{id}';

    /**
     * @var array
     */
    protected static $map = [
        'id',
        'uuid',
        'createdAt',
        'updatedAt',
        'owner',
        'ownerUuid',
        'possessor',
        'possessorUuid',
        'permissions',
        'version'
    ];

    /**
     * Get access list
     *
     * @param \Ds\Component\Api\Query\AccessParameters $parameters
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
