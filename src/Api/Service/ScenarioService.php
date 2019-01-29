<?php

namespace Ds\Component\Api\Service;

use Ds\Component\Api\Model\Scenario;
use Ds\Component\Api\Query\ScenarioParameters as Parameters;

/**
 * Class ScenarioService
 *
 * @package Ds\Component\Api
 */
final class ScenarioService implements Service
{
    use Base;

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
    private static $map = [
        'id',
        'uuid'
    ];

    /**
     * Get scenario list
     *
     * @param \Ds\Component\Api\Query\ScenarioParameters $parameters
     * @return array
     */
    public function getList(Parameters $parameters = null): array
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
