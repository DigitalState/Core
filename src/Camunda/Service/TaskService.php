<?php

namespace Ds\Component\Camunda\Service;

use Ds\Component\Api\Service\Service;
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
final class TaskService implements Service
{
    use Base {
        toModel as protected baseToModel;
    }

    /**
     * @const string
     */
    const MODEL = Task::class;

    /**
     * @const string
     */
    const RESOURCE_LIST = '/rest/task';
    const RESOURCE_LIST_BY_TASK_ID = '/custom/task-search';
    const RESOURCE_COUNT = '/rest/task/count';
    const RESOURCE_OBJECT = '/rest/task/{id}';
    const RESOURCE_SUBMIT = '/rest/task/{id}/submit-form';
    const RESOURCE_CLAIM = '/rest/task/{id}/claim';
    const RESOURCE_UNCLAIM = '/rest/task/{id}/unclaim';

    /**
     * @var array
     */
    private static $map = [
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
            'headers' => [
                'Accept' => 'application/json'
            ]
        ];

        $query = (array) $parameters->toObject(true);

        if (array_key_exists('taskIdIn', $query)) {
            $resource = static::RESOURCE_LIST_BY_TASK_ID.'?';

            foreach ($query['taskIdIn'] as $taskId) {
                $resource .= 'taskIdIn[]='.urlencode($taskId).'&';
            }

            $resource = substr($resource, 0, -1);
        } else {
            $resource = static::RESOURCE_LIST;
            $options['query'] = $query;
        }

        $objects = $this->execute('GET', $resource, $options);
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
        $options = [
            'headers' => [
                'Accept' => 'application/json'
            ],
            'query' => (array)  $parameters->toObject(true)
        ];
        $result = $this->execute('GET', static::RESOURCE_COUNT, $options);

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
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ]
        ];

        foreach ($variables as $variable) {
            // @todo Standardize variable toObject logic (see ProcessInstanceService::start)
            $options['json']['variables'][$variable->getName()] = [
                'value' => Variable::TYPE_JSON === $variable->getType() ? json_encode($variable->getValue()) : $variable->getValue(),
                'type' => $variable->getType()
            ];
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
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ],
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
        $options = [
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ]
        ];
        $resource = str_replace('{id}', $id, static::RESOURCE_UNCLAIM);
        $this->execute('POST', $resource, $options);
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
        $model = static::baseToModel($object);

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
