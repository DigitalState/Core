<?php

namespace Ds\Component\Formio\Service;

use Ds\Component\Api\Service\Service;
use Ds\Component\Formio\Model\Role;

/**
 * Class RoleService
 *
 * @package Ds\Component\Formio
 */
final class RoleService implements Service
{
    use Base;

    /**
     * @const string
     */
    const MODEL = Role::class;

    /**
     * @const string
     */
    const RESOURCE_LIST = '/role';

    /**
     * @var array
     */
    private static $map = [
        'id' => '_id',
        'created',
        'updated' => 'modified',
        'title',
        'machineName',
        'description',
        'admin',
        'default'
    ];

    /**
     * Get role list
     *
     * @return array
     */
    public function getList(): array
    {
        $objects = $this->execute('GET', static::RESOURCE_LIST);
        $list = [];

        foreach ($objects as $name => $object) {
            $model = static::toModel($object);
            $list[] = $model;
        }

        return $list;
    }
}
