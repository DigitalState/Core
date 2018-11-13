<?php

namespace Ds\Component\Api\Service;

use Ds\Component\Api\Model\User;
use Ds\Component\Api\Query\UserParameters as Parameters;

/**
 * Class UserService
 *
 * @package Ds\Component\Api
 */
final class UserService implements Service
{
    use Base;

    /**
     * @const string
     */
    const MODEL = User::class;

    /**
     * @const string
     */
    const RESOURCE_LIST = '/users';
    const RESOURCE_OBJECT = '/users/{id}';

    /**
     * @var array
     */
    private static $map = [
        'id',
        'uuid',
        'createdAt',
        'updatedAt',
        'username',
        'email',
        'enabled',
        'lastLogin',
        'owner',
        'ownerUuid',
        'identity',
        'identityUuid',
        'version'
    ];

    /**
     * Get user list
     *
     * @param \Ds\Component\Api\Query\UserParameters $parameters
     * @return array
     */
    public function getList(Parameters $parameters = null): array
    {
        $objects = $this->execute('GET', static::RESOURCE_LIST);
        $list = [];

        foreach ($objects as $object) {
            $model = static::toModel($object);
            $list[] = $model;
        }

        return $list;
    }

    /**
     * Get user list
     *
     * @param string $id
     * @param \Ds\Component\Api\Query\UserParameters $parameters
     * @return \Ds\Component\Api\Model\User
     */
    public function get($id, Parameters $parameters = null): User
    {
        $resource = str_replace('{id}', $id, static::RESOURCE_OBJECT);
        $object = $this->execute('GET', $resource);
        /** @var \Ds\Component\Api\Model\User $model */
        $model = static::toModel($object);

        return $model;
    }
}
