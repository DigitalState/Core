<?php

namespace Ds\Component\Api\Service;

use Ds\Component\Api\Model\StaffPersona;
use Ds\Component\Api\Query\StaffPersonaParameters as Parameters;

/**
 * Class StaffPersonaService
 *
 * @package Ds\Component\Api
 */
class StaffPersonaService extends AbstractService
{
    /**
     * @const string
     */
    const MODEL = StaffPersona::class;

    /**
     * @const string
     */
    const RESOURCE_LIST = '/staff-personas';
    const RESOURCE_OBJECT = '/staff-personas/{id}';

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
     * Get staff persona list
     *
     * @param \Ds\Component\Api\Query\StaffPersonaParameters $parameters
     * @return array
     */
    public function getList(Parameters $parameters = null)
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
    public function get($id, Parameters $parameters = null)
    {
        $resource = str_replace('{id}', $id, static::RESOURCE_OBJECT);
        $object = $this->execute('GET', $resource);
        $model = static::toModel($object);

        return $model;
    }
}
