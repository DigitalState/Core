<?php

namespace Ds\Component\Api\Service;

use Ds\Component\Api\Model\OrganizationPersona;
use Ds\Component\Api\Query\OrganizationPersonaParameters as Parameters;

/**
 * Class OrganizationPersonaService
 *
 * @package Ds\Component\Api
 */
class OrganizationPersonaService extends AbstractService
{
    /**
     * @const string
     */
    const MODEL = OrganizationPersona::class;

    /**
     * @const string
     */
    const RESOURCE_LIST = '/organization-personas';
    const RESOURCE_OBJECT = '/organization-personas/{id}';

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
        'organization',
        'title',
        'data',
        'version'
    ];

    /**
     * Get organization persona list
     *
     * @param \Ds\Component\Api\Query\OrganizationPersonaParameters $parameters
     * @return array
     */
    public function getList(Parameters $parameters = null)
    {
        $options = [];

        if ($parameters) {
            $options['query'] = (array) $parameters->toObject(true);

            if (array_key_exists('organizationUuid', $options['query'])) {
                $options['query']['organization.uuid'] = $options['query']['organizationUuid'];
                unset($options['query']['organizationUuid']);
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
     * Get organization persona
     *
     * @param string $id
     * @param \Ds\Component\Api\Query\OrganizationPersonaParameters $parameters
     * @return \Ds\Component\Api\Model\OrganizationPersona
     */
    public function get($id, Parameters $parameters = null)
    {
        $resource = str_replace('{id}', $id, static::RESOURCE_OBJECT);
        $object = $this->execute('GET', $resource);
        $model = static::toModel($object);

        return $model;
    }

    /**
     * Create organization persona
     *
     * @param \Ds\Component\Api\Model\OrganizationPersona $persona
     * @param \Ds\Component\Api\Query\OrganizationPersonaParameters $parameters
     * @return \Ds\Component\Api\Model\OrganizationPersona
     */
    public function create(OrganizationPersona $persona, Parameters $parameters = null)
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
