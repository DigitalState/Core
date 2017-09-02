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
     */
    public function __construct(ClientInterface $client, $host = null)
    {
        $this->processDefinition = new Service\ProcessDefinitionService($client, $host);
        $this->processInstance = new Service\ProcessInstanceService($client, $host);
        $this->task = new Service\TaskService($client, $host);
    }

    /**
     * Set host
     *
     * @param string $host
     * @return \Ds\Component\Camunda\Api\Api
     */
    public function setHost($host)
    {
        $this->processDefinition->setHost($host);
        $this->processInstance->setHost($host);
        $this->task->setHost($host);
    }
}
