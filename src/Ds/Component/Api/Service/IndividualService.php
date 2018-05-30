<?php

namespace Ds\Component\Api\Service;

use Ds\Component\Api\Model\Individual;
use Ds\Component\Api\Query\IndividualParameters as Parameters;

/**
 * Class IndividualService
 *
 * @package Ds\Component\Api
 */
class IndividualService extends AbstractService
{
    /**
     * @const string
     */
    const MODEL = Individual::class;

    /**
     * @const string
     */
    const RESOURCE_LIST = '/individuals';
    const RESOURCE_OBJECT = '/individuals/{id}';

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
        'version',
        'tenant'
    ];

    /**
     * Get individual list
     *
     * @param \Ds\Component\Api\Query\IndividualParameters $parameters
     * @return array
     */
    public function getList(Parameters $parameters = null)
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
     * Get individual
     *
     * @param string $id
     * @param \Ds\Component\Api\Query\IndividualParameters $parameters
     * @return \Ds\Component\Api\Model\Individual
     */
    public function get($id, Parameters $parameters = null)
    {
        $resource = str_replace('{id}', $id, static::RESOURCE_OBJECT);
        $object = $this->execute('GET', $resource);
        $model = static::toModel($object);

        return $model;
    }

    /**
     * Create individual
     *
     * @param \Ds\Component\Api\Model\Individual $individual
     * @param \Ds\Component\Api\Query\IndividualParameters $parameters
     * @return \Ds\Component\Api\Model\Individual
     */
    public function create(Individual $individual, Parameters $parameters = null)
    {
        $options = [];
        $options['json'] = (array) static::toObject($individual);

        if ($parameters) {
            $options['query'] = (array) $parameters->toObject(true);
        }

        $object = $this->execute('POST', static::RESOURCE_LIST, $options);
        $individual = static::toModel($object);

        return $individual;
    }
}
