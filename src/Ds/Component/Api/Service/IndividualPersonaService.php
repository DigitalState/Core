<?php

namespace Ds\Component\Api\Service;

use Ds\Component\Api\Model\IndividualPersona;
use Ds\Component\Api\Query\IndividualPersonaParameters as Parameters;

/**
 * Class IndividualPersonaService
 *
 * @package Ds\Component\Api
 */
class IndividualPersonaService extends AbstractService
{
    /**
     * @const string
     */
    const MODEL = IndividualPersona::class;

    /**
     * @const string
     */
    const RESOURCE_LIST = '/individual-personas';
    const RESOURCE_OBJECT = '/individual-personas/{id}';

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
        'identity',
        'identityUuid',
        'individual',
        'title',
        'data',
        'version'
    ];

    /**
     * Get individual persona list
     *
     * @param \Ds\Component\Api\Query\IndividualPersonaParameters $parameters
     * @return array
     */
    public function getList(Parameters $parameters = null)
    {
        $options = [];

        if ($parameters) {
            $options['query'] = (array) $parameters->toObject(true);

            if (array_key_exists('individualUuid', $options['query'])) {
                $options['query']['individual.uuid'] = $options['query']['individualUuid'];
                unset($options['query']['individualUuid']);
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
     * Get individual persona
     *
     * @param string $id
     * @param \Ds\Component\Api\Query\IndividualPersonaParameters $parameters
     * @return \Ds\Component\Api\Model\IndividualPersona
     */
    public function get($id, Parameters $parameters = null)
    {
        $resource = str_replace('{id}', $id, static::RESOURCE_OBJECT);
        $object = $this->execute('GET', $resource);
        $model = static::toModel($object);

        return $model;
    }

    /**
     * Create individual persona
     *
     * @param \Ds\Component\Api\Model\IndividualPersona $persona
     * @param \Ds\Component\Api\Query\IndividualPersonaParameters $parameters
     * @return \Ds\Component\Api\Model\IndividualPersona
     */
    public function create(IndividualPersona $persona, Parameters $parameters = null)
    {
        $options = [];
        $options['json'] = (array) static::toObject($persona);

        if ($parameters) {
            $options['query'] = (array) $parameters->toObject(true);
        }

        $object = $this->execute('POST', static::RESOURCE_LIST, $options);
        $persona = static::toModel($object);

        return $persona;
    }
}
