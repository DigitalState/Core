<?php

namespace Ds\Component\Api\Service\Identities;

use Ds\Component\Api\Model\Identities\Individual;
use Ds\Component\Api\Query\Identities\IndividualParameters as Parameters;
use Ds\Component\Api\Service\AbstractService;

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
    const RESOURCE_LIST = '/individual';
    const RESOURCE_OBJECT = '/individual/{id}';

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
     * @param \Ds\Component\Api\Query\Identities\IndividualParameters $parameters
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
