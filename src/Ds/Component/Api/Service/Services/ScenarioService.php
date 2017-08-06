<?php

namespace Ds\Component\Api\Service\Services;

use Ds\Component\Api\Model\Services\Scenario;
use Ds\Component\Api\Query\Services\ScenarioParameters as Parameters;
use Ds\Component\Api\Service\AbstractService;

/**
 * Class ScenarioService
 *
 * @package Ds\Component\Api
 */
class ScenarioService extends AbstractService
{
    /**
     * @const string
     */
    const MODEL = Scenario::class;

    /**
     * @const string
     */
    const RESOURCE_LIST = '/scenarios';
    const RESOURCE_OBJECT = '/scenarios/{id}';

    /**
     * @var array
     */
    protected static $map = [
        'id',
        'uuid'
    ];

    /**
     * Get scenario list
     *
     * @param \Ds\Component\Api\Query\Services\ScenarioParameters $parameters
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
