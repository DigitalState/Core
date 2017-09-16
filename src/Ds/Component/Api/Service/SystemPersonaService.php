<?php

namespace Ds\Component\Api\Service;

use Ds\Component\Api\Model\SystemPersona;
use Ds\Component\Api\Query\SystemPersonaParameters as Parameters;

/**
 * Class SystemPersonaService
 *
 * @package Ds\Component\Api
 */
class SystemPersonaService extends AbstractService
{
    /**
     * @const string
     */
    const MODEL = SystemPersona::class;

    /**
     * @const string
     */
    const RESOURCE_LIST = '/system-personas';
    const RESOURCE_OBJECT = '/system-personas/{id}';

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
        'title',
        'data',
        'version'
    ];

    /**
     * Get system persona list
     *
     * @param \Ds\Component\Api\Query\SystemPersonaParameters $parameters
     * @return array
     */
    public function getList(Parameters $parameters = null)
    {
        $options = [];

        if ($parameters) {
            $options['query'] = (array) $parameters->toObject(true);

            if (array_key_exists('systemUuid', $options['query'])) {
                $options['query']['system.uuid'] = $options['query']['systemUuid'];
                unset($options['query']['systemUuid']);
            }
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
     * Get system persona
     *
     * @param string $id
     * @param \Ds\Component\Api\Query\SystemPersonaParameters $parameters
     * @return \Ds\Component\Api\Model\SystemPersona
     */
    public function get($id, Parameters $parameters = null)
    {
        $resource = str_replace('{id}', $id, static::RESOURCE_OBJECT);
        $object = $this->execute('GET', $resource);
        $model = static::toModel($object);

        return $model;
    }
}
