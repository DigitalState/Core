<?php

namespace Ds\Component\Api\Service;

use Ds\Component\Api\Model\Individual;
use Ds\Component\Api\Query\IndividualParameters as Parameters;

/**
 * Class IndividualService
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
    const RESOURCE_LIST = '/form';
    const RESOURCE_OBJECT = '/form/{id}';

    /**
     * @var array
     */
    protected static $map = [
        'id',
        'uuid'
    ];

    /**
     * Get individual list
     *
     * @param \Ds\Component\Api\Query\IndividualParameters $parameters
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
