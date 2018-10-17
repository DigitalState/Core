<?php

namespace Ds\Component\Camunda\Model\Attribute;

/**
 * Trait TaskDefinitionKey
 *
 * @package Ds\Component\Camunda
 */
trait TaskDefinitionKey
{
    /**
     * @var string
     */
    protected $taskDefinitionKey; # region accessors

    /**
     * Set task definition key
     *
     * @param string $taskDefinitionKey
     * @return object
     */
    public function setTaskDefinitionKey($taskDefinitionKey)
    {
        $this->taskDefinitionKey = $taskDefinitionKey;

        return $this;
    }

    /**
     * Get task definition key
     *
     * @return string
     */
    public function getTaskDefinitionKey()
    {
        return $this->taskDefinitionKey;
    }

    # endregion
}
