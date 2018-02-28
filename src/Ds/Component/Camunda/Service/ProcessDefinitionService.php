<?php

namespace Ds\Component\Camunda\Service;

use Ds\Component\Camunda\Model\ProcessDefinition;
use Ds\Component\Camunda\Model\Variable;
use Ds\Component\Camunda\Model\Xml;
use Ds\Component\Camunda\Query\ProcessDefinitionParameters as Parameters;
use SimpleXMLElement;

/**
 * Class ProcessDefinitionService
 *
 * @package Ds\Component\Camunda
 */
class ProcessDefinitionService extends AbstractService
{
    /**
     * @const string
     */
    const MODEL = ProcessDefinition::class;

    /**
     * @const string
     */
    const RESOURCE_LIST = '/process-definition';
    const RESOURCE_COUNT = '/process-definition/count';
    const RESOURCE_OBJECT = '/process-definition/{id}';
    const RESOURCE_OBJECT_BY_KEY = '/process-definition/key/{key}';
    const RESOURCE_OBJECT_XML = '/process-definition/{id}/xml';
    const RESOURCE_OBJECT_XML_BY_KEY = '/process-definition/key/{key}/xml';
    const RESOURCE_OBJECT_START = '/process-definition/{id}/start';
    const RESOURCE_OBJECT_START_BY_KEY = '/process-definition/key/{key}/start';
    const RESOURCE_OBJECT_START_FORM = '/process-definition/{id}/startForm';
    const RESOURCE_OBJECT_START_FORM_BY_KEY = '/process-definition/key/{key}/startForm';

    /**
     * @var array
     */
    protected static $map = [
        'id',
        'key',
        'name',
        'description',
        'category',
        'resource',
        'deploymentId',
        'diagram',
        'tenantId',
        'version',
        'versionTag'
    ];

    /**
     * Get list of process definitions
     *
     * @param \Ds\Component\Camunda\Query\ProcessDefinitionParameters $parameters
     * @return array
     */
    public function getList(Parameters $parameters = null)
    {
        $options = [
            'headers' => [
                'Accept' => 'application/json'
            ]
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
     * Get count of process definitions
     *
     * @param \Ds\Component\Camunda\Query\ProcessDefinitionParameters $parameters
     * @return integer
     */
    public function getCount(Parameters $parameters = null)
    {
        $options = [
            'headers' => [
                'Accept' => 'application/json'
            ]
        ];
        $result = $this->execute('GET', static::RESOURCE_COUNT, $options);

        return $result->count;
    }

    /**
     * Get process definition
     *
     * @param string $id
     * @param \Ds\Component\Camunda\Query\ProcessDefinitionParameters $parameters
     * @return \Ds\Component\Camunda\Model\ProcessDefinition
     */
    public function get($id, Parameters $parameters = null)
    {
        if (null !== $id) {
            $resource = str_replace('{id}', $id, static::RESOURCE_OBJECT);
        } else {
            $resource = str_replace('{key}', $parameters->getKey(), static::RESOURCE_OBJECT_BY_KEY);
        }

        $options = [
            'headers' => [
                'Accept' => 'application/json'
            ]
        ];
        $object = $this->execute('GET', $resource, $options);
        $model = static::toModel($object);

        return $model;
    }

    /**
     * Get process definition xml
     *
     * @param string $id
     * @param \Ds\Component\Camunda\Query\ProcessDefinitionParameters $parameters
     * @return string
     */
    public function getXml($id, Parameters $parameters = null)
    {
        if (null !== $id) {
            $resource = str_replace('{id}', $id, static::RESOURCE_OBJECT_XML);
        } else {
            $resource = str_replace('{key}', $parameters->getKey(), static::RESOURCE_OBJECT_XML_BY_KEY);
        }

        $options = [
            'headers' => [
                'Accept' => 'application/json'
            ]
        ];
        $object = $this->execute('GET', $resource, $options);
        $model = new Xml;
        $model
            ->setId($object->id)
            ->setXml(new SimpleXMLElement($object->bpmn20Xml));

        return $model;
    }

    /**
     * Start a process definition instance
     *
     * @param string $id
     * @param \Ds\Component\Camunda\Query\ProcessDefinitionParameters $parameters
     * @return \Ds\Component\Camunda\Model\ProcessInstance
     */
    public function start($id, Parameters $parameters = null)
    {
        if (null !== $id) {
            $resource = str_replace('{id}', $id, static::RESOURCE_OBJECT_START);
        } else {
            $resource = str_replace('{key}', $parameters->getKey(), static::RESOURCE_OBJECT_START_BY_KEY);
        }

        $options = [
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ]
        ];

        if ($parameters) {
            $parameters = (array) $parameters->toObject(true);

            foreach ($parameters as $name => $value) {
                switch ($name) {
                    case 'variables':
                        foreach ($value as $variable) {
                            $options['json'][$name][$variable->name] = [
                                'value' => Variable::TYPE_JSON === $variable->type ? json_encode($variable->value) : $variable->value,
                                'type' => $variable->type
                            ];
                        }

                        break;

                    case 'key':
                        break;

                    default:
                        $options['json'][$name] = $value;
                }
            }
        }

        $object = $this->execute('POST', $resource, $options);
        $model = ProcessInstanceService::toModel($object);

        return $model;
    }

    /**
     * Get process definition start form
     *
     * @param string $id
     * @param \Ds\Component\Camunda\Query\ProcessDefinitionParameters $parameters
     * @return string
     */
    public function getStartForm($id, Parameters $parameters = null)
    {
        if (null !== $id) {
            $resource = str_replace('{id}', $id, static::RESOURCE_OBJECT_START_FORM);
        } else {
            $resource = str_replace('{key}', $parameters->getKey(), static::RESOURCE_OBJECT_START_FORM_BY_KEY);
        }

        $options = [
            'headers' => [
                'Accept' => 'application/json'
            ]
        ];
        $result = $this->execute('GET', $resource, $options);

        return $result->key;
    }
}
