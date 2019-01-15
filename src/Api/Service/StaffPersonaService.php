<?php

namespace Ds\Component\Api\Service;

use Ds\Component\Api\Model\StaffPersona;
use Ds\Component\Api\Query\StaffPersonaParameters as Parameters;

/**
 * Class StaffPersonaService
 *
 * @package Ds\Component\Api
 */
final class StaffPersonaService implements Service
{
    use Base;

    /**
     * @const string
     */
    const MODEL = StaffPersona::class;

    /**
     * @const string
     */
    const RESOURCE_LIST = '/staff_personas';
    const RESOURCE_OBJECT = '/staff_personas/{id}';

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
     * Get staff persona list
     *
     * @param \Ds\Component\Api\Query\StaffPersonaParameters $parameters
     * @return array
     */
    public function getList(Parameters $parameters = null): array
    {
        $options = [];

        if ($parameters) {
            $options['query'] = (array) $parameters->toObject(true);

            if (array_key_exists('staffUuid', $options['query'])) {
                $options['query']['staff.uuid'] = $options['query']['staffUuid'];
                unset($options['query']['staffUuid']);
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
     * Get staff persona
     *
     * @param string $id
     * @param \Ds\Component\Api\Query\StaffPersonaParameters $parameters
     * @return \Ds\Component\Api\Model\StaffPersona
     */
    public function get(string $id, Parameters $parameters = null): StaffPersona
    {
        $resource = str_replace('{id}', $id, static::RESOURCE_OBJECT);
        $object = $this->execute('GET', $resource);
        /** @var \Ds\Component\Api\Model\StaffPersona $model */
        $model = static::toModel($object);

        return $model;
    }
}
