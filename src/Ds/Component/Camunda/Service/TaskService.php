<?php

namespace Ds\Component\Camunda\Service;

use Ds\Component\Camunda\Model\Task;
use Ds\Component\Camunda\Model\Variable;
use Ds\Component\Camunda\Query\TaskParameters as Parameters;
use InvalidArgumentException;
use stdClass;

/**
 * Class TaskService
 *
 * @package Ds\Component\Camunda
 */
class TaskService extends AbstractService
{
    /**
     * @const string
     */
    const MODEL = Task::class;

    /**
     * @const string
     */
    const RESOURCE_LIST = '/task';
    const RESOURCE_COUNT = '/task/count';
    const RESOURCE_OBJECT = '/task/{id}';
    const RESOURCE_SUBMIT = '/task/{id}/submit-form';
    const RESOURCE_CLAIM = '/task/{id}/claim';
    const RESOURCE_UNCLAIM = '/task/{id}/unclaim';

    /**
     * @var array
     */
    protected static $map = [
        'id',
        'name',
        'assignee',
        'created',
        'due',
        'followUp',
        'delegationState',
        'description',
        'executionId',
        'owner',
        'parentTaskId',
        'priority',
        'processDefinitionId',
        'processInstanceId',
        'caseExecutionId',
        'caseDefinitionId',
        'caseInstanceId',
        'taskDefinitionKey',
        'formKey',
        'tenantId'
    ];

    /**
     * @var \Ds\Component\Camunda\Service\Task\VariableService
     */
    public $variable;

    /**
     * Get task list
     *
     * @param \Ds\Component\Camunda\Query\TaskParameters $parameters
     * @return array
     */
    public function getList(Parameters $parameters = null)
    {
        $options = [
            'query' => (array)  $parameters->toObject(true)
        ];
        $objects = $this->execute('GET', static::RESOURCE_LIST, $options);
        $list = [];

        foreach ($objects as $object) {
            $model = static::toModel($object);
            $list[] = $model;
        }

        return $list;
    }

    /**
     * Get count
     *
     * @param \Ds\Component\Camunda\Query\TaskParameters $parameters
     * @return integer
     */
    public function getCount(Parameters $parameters = null)
    {
        $result = $this->execute('GET', static::RESOURCE_COUNT);

        return $result->count;
    }

    /**
     * Get task
     *
     * @param string $id
     * @return \Ds\Component\Camunda\Model\Task
     */
    public function get($id)
    {
        $resource = str_replace('{id}', $id, static::RESOURCE_OBJECT);
        $options = [
            'headers' => [
                'Accept' => 'application/hal+json'
            ]
        ];
        $object = $this->execute('GET', $resource, $options);
        $model = static::toModel($object);

        return $model;
    }

    /**
     * Submit task data
     *
     * @param string $id
     * @param array $variables
     * @throws \InvalidArgumentException
     */
    public function submit($id, array $variables)
    {
        foreach ($variables as $variable) {
            if (!$variable instanceof Variable) {
                throw new InvalidArgumentException('Array of variables is not valid.');
            }
        }

        $resource = str_replace('{id}', $id, static::RESOURCE_SUBMIT);
        $options = [
            'json' => [
                'variables' => []
            ]
        ];

        foreach ($variables as $variable) {
            $options['json']['variables'][$variable->getName()] = (array) $variable->toObject(true);
        }

        $this->execute('POST', $resource, $options);
    }

    /**
     * Claim task
     *
     * @param string $id
     * @param string $userId
     */
    public function claim($id, $userId)
    {
        $resource = str_replace('{id}', $id, static::RESOURCE_CLAIM);
        $options = [
            'json' => [
                'userId' => $userId
            ]
        ];
        $this->execute('POST', $resource, $options);
    }

    /**
     * Unclaim task
     *
     * @param string $id
     */
    public function unclaim($id)
    {
        $resource = str_replace('{id}', $id, static::RESOURCE_UNCLAIM);
        $this->execute('POST', $resource);
    }

    /**
     * Cast object to model
     *
     * @param \stdClass $object
     * @return \Ds\Component\Camunda\Model\Model
     * @throws \LogicException
     */
    public static function toModel(stdClass $object)
    {
        $model = parent::toModel($object);

        // @todo Parse everything that is embedded
        if (isset($object->_embedded->identityLink)) {
            foreach ($object->_embedded->identityLink as $identity) {
                if ('candidate' === $identity->type) {
                    $model->setCandidateGroup($identity->groupId);
                }
            }
        }

        return $model;
    }
}
