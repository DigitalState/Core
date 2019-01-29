<?php

namespace Ds\Component\Api\Service;

use Ds\Component\Api\Model\AnonymousPersona;
use Ds\Component\Api\Query\AnonymousPersonaParameters as Parameters;

/**
 * Class AnonymousPersonaService
 *
 * @package Ds\Component\Api
 */
final class AnonymousPersonaService implements Service
{
    use Base;

    /**
     * @const string
     */
    const MODEL = AnonymousPersona::class;

    /**
     * @const string
     */
    const RESOURCE_LIST = '/anonymous_personas';
    const RESOURCE_OBJECT = '/anonymous_personas/{id}';

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
    public function getList(Parameters $parameters = null): array
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
    public function get($id, Parameters $parameters = null): AnonymousPersona
    {
        $resource = str_replace('{id}', $id, static::RESOURCE_OBJECT);
        $object = $this->execute('GET', $resource);
        /** @var \Ds\Component\Api\Model\AnonymousPersona $model */
        $model = static::toModel($object);

        return $model;
    }
}
