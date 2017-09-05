<?php

namespace Ds\Component\Camunda\Api;

use GuzzleHttp\ClientInterface;
use Ds\Component\Camunda\Service;

/**
 * Class Api
 *
 * @package Ds\Component\Camunda
 */
class Api
{
    /**
     * @var \Ds\Component\Camunda\Service\ProcessDefinitionService
     */
    public $processDefinition;

    /**
     * @var \Ds\Component\Camunda\Service\ProcessInstanceService
     */
    public $processInstance;

    /**
     * @var \Ds\Component\Camunda\Service\TaskService
     */
    public $task;

    /**
     * Constructor
     *
     * @param \GuzzleHttp\ClientInterface $client
     * @param string $host
     * @param array $authorization
     */
    public function __construct(ClientInterface $client, $host = null, array $authorization = [])
    {
        $this->processDefinition = new Service\ProcessDefinitionService($client, $host, $authorization);
        $this->processInstance = new Service\ProcessInstanceService($client, $host, $authorization);
        $this->task = new Service\TaskService($client, $host, $authorization);
    }

    /**
     * Set host
     *
     * @param string $host
     * @return \Ds\Component\Camunda\Api\Api
     */
    public function setHost($host = null)
    {
        $this->processDefinition->setHost($host);
        $this->processInstance->setHost($host);
        $this->task->setHost($host);
    }

    /**
     * Set authorization
     *
     * @param array $authorization
     * @return \Ds\Component\Camunda\Api\Api
     */
    public function setAuthorization(array $authorization = [])
    {
        $this->processDefinition->setAuthorization($authorization);
        $this->processInstance->setAuthorization($authorization);
        $this->task->setAuthorization($authorization);
    }
}
