<?php

namespace Ds\Component\Api\Service;

use Ds\Component\Api\Model\AnonymousPersona;
use Ds\Component\Api\Query\AnonymousPersonaParameters as Parameters;

/**
 * Class AnonymousPersonaService
 *
 * @package Ds\Component\Api
 */
class AnonymousPersonaService extends AbstractService
{
    /**
     * @const string
     */
    const MODEL = AnonymousPersona::class;

    /**
     * @const string
     */
    const RESOURCE_LIST = '/anonymous-personas';
    const RESOURCE_OBJECT = '/anonymous-personas/{id}';

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
     * Get anonymous persona list
     *
     * @param \Ds\Component\Api\Query\AnonymousPersonaParameters $parameters
     * @return array
     */
    public function getList(Parameters $parameters = null)
    {
        $options = [];

        if ($parameters) {
            $options['query'] = (array) $parameters->toObject(true);

            if (array_key_exists('anonymousUuid', $options['query'])) {
                $options['query']['anonymous.uuid'] = $options['query']['anonymousUuid'];
                unset($options['query']['anonymousUuid']);
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
     * Get anonymous persona
     *
     * @param string $id
     * @param \Ds\Component\Api\Query\AnonymousPersonaParameters $parameters
     * @return \Ds\Component\Api\Model\AnonymousPersona
     */
    public function get($id, Parameters $parameters = null)
    {
        $resource = str_replace('{id}', $id, static::RESOURCE_OBJECT);
        $object = $this->execute('GET', $resource);
        $model = static::toModel($object);

        return $model;
    }
}
