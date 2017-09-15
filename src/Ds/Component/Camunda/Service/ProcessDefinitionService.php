<?php

namespace Ds\Component\Camunda\Service;

use Ds\Component\Camunda\Model\Xml;
use Ds\Component\Camunda\Query\ProcessDefinitionParameters as Parameters;
use Ds\Component\Camunda\Model\ProcessDefinition;
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
     * {@inheritdoc}
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
     * {@inheritdoc}
     */
    public function getCount(Parameters $parameters = null)
    {
        $result = $this->execute('GET', static::RESOURCE_COUNT);

        return $result->count;
    }

    /**
     * {@inheritdoc}
     */
    public function get($id, Parameters $parameters = null)
    {
        if (null !== $id) {
            $resource = str_replace('{id}', $id, static::RESOURCE_OBJECT);
        } else {
            $resource = str_replace('{key}', $parameters->getKey(), static::RESOURCE_OBJECT_BY_KEY);
        }

        $object = $this->execute('GET', $resource);
        $model = static::toModel($object);

        return $model;
    }

    /**
     * {@inheritdoc}
     */
    public function getXml($id, Parameters $parameters = null)
    {
        if (null !== $id) {
            $resource = str_replace('{id}', $id, static::RESOURCE_OBJECT_XML);
        } else {
            $resource = str_replace('{key}', $parameters->getKey(), static::RESOURCE_OBJECT_XML_BY_KEY);
        }

        $object = $this->execute('GET', $resource);
        $model = new Xml;
        $model
            ->setId($object->id)
            ->setXml(new SimpleXMLElement($object->bpmn20Xml));

        return $model;
    }

    /**
     * {@inheritdoc}
     */
    public function start($id, Parameters $parameters = null)
    {
        if (null !== $id) {
            $resource = str_replace('{id}', $id, static::RESOURCE_OBJECT_START);
        } else {
            $resource = str_replace('{key}', $parameters->getKey(), static::RESOURCE_OBJECT_START_BY_KEY);
        }

        $options = [];

        if ($parameters) {
            foreach ($parameters->getVariables() as $variable) {
                $options['json']['variables'][$variable->getName()] = [
                    'value' => $variable->getValue(),
                    'type' => $variable->getType()
                ];

                if ('json' === $variable->getType()) {
                    $options['json']['variables'][$variable->getName()]['value'] =
                        json_encode($options['json']['variables'][$variable->getName()]['value']);
                }
            }
        }

        $object = $this->execute('POST', $resource, $options);
        $model = ProcessInstanceService::toModel($object);

        return $model;
    }

    /**
     * {@inheritdoc}
     */
    public function getStartForm($id, Parameters $parameters = null)
    {
        if (null !== $id) {
            $resource = str_replace('{id}', $id, static::RESOURCE_OBJECT_START_FORM);
        } else {
            $resource = str_replace('{key}', $parameters->getKey(), static::RESOURCE_OBJECT_START_FORM_BY_KEY);
        }

        $result = $this->execute('GET', $resource);

        return $result->key;
    }
}
