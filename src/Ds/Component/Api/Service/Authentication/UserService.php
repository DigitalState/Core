<?php

namespace Ds\Component\Api\Service\Authentication;

use Ds\Component\Api\Model\Authentication\User;
use Ds\Component\Api\Query\Authentication\UserParameters as Parameters;
use Ds\Component\Api\Service\AbstractService;

/**
 * Class UserService
 *
 * @package Ds\Component\Api
 */
class UserService extends AbstractService
{
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
    protected static $map = [
        'id',
        'uuid'
    ];

    /**
     * Get user list
     *
     * @param \Ds\Component\Api\Query\Authentication\UserParameters $parameters
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
