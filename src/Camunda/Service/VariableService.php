<?php

namespace Ds\Component\Camunda\Service;

use Ds\Component\Api\Service\Service;
use Ds\Component\Camunda\Model\Variable;
use Ds\Component\Camunda\Query\VariableParameters as Parameters;
use stdClass;

/**
 * Class VariableService
 *
 * @package Ds\Component\Camunda
 */
abstract class VariableService implements Service
{
    use Base;

    /**
     * @const string
     */
    const MODEL = Variable::class;

    /**
     * @const string
     */
    const VARIABLE_LIST = null;

    /**
     * @var array
     */
    protected static $map = [
        'name',
        'value',
        'type',
        'valueInfo'
    ];

    /**
     * Get task list
     *
     * @parma string $task
     * @param \Ds\Component\Camunda\Query\VariableParameters $parameters
     * @return array
     */
    public function getList($task, Parameters $parameters = null)
    {
        $resource = str_replace('{id}', $task, static::VARIABLE_LIST);
        $options = [
            'headers' => [
                'Accept' => 'application/json'
            ],
            'query' => (array)  $parameters->toObject(true)
        ];
        $objects = $this->execute('GET', $resource, $options);
        $list = [];

        foreach ($objects as $name => $object) {
            $object->name = $name;
            $model = static::toModel($object);
            $list[$name] = $model;
        }

        return $list;
    }

    /**
     * {@inheritdoc}
     */
    public static function toModel(stdClass $object)
    {
        $model = Base::toModel($object);

        if (Variable::TYPE_JSON === $model->getType()) {
            $model->setValue(json_decode($model->getValue()));
        }

        return $model;
    }
}
