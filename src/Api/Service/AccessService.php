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
        'assignee',
        'assigneeUuid',
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
        $options = [];

        if ($parameters) {
            $options['query'] = (array) $parameters->toObject(true);
        }

        $objects = $this->execute('GET', static::RESOURCE_LIST, $options);
        $list = [];

        foreach ($objects as $object) {
            $model = static::toModel($object);
            $list[] = $model;
        }

        return $list;
    }

    /**
     * Create access
     *
     * @param \Ds\Component\Api\Model\Access $access
     * @param \Ds\Component\Api\Query\AccessParameters $parameters
     * @return \Ds\Component\Api\Model\Individual
     */
    public function create(Access $access, Parameters $parameters = null)
    {
        $options = [];
        $options['json'] = (array) static::toObject($access);

        if ($parameters) {
            $options['query'] = (array) $parameters->toObject(true);
        }

        $object = $this->execute('POST', static::RESOURCE_LIST, $options);
        $access = static::toModel($object);

        return $access;
    }

    /**
     * Delete access
     *
     * @param \Ds\Component\Api\Model\Access $access
     */
    public function delete(Access $access)
    {
        $resource = str_replace('{id}', $access->getUuid(), static::RESOURCE_OBJECT);
        $this->execute('DELETE', $resource);
    }
}
