<?php

namespace Ds\Component\Camunda\Model\Attribute;

/**
 * Trait ProcessDefinitionId
 *
 * @package Ds\Component\Camunda
 */
trait ProcessDefinitionId
{
    /**
     * @var string
     */
    protected $processDefinitionId; # region accessors

    /**
     * Set process definition id
     *
     * @param string $processDefinitionId
     * @return object
     */
    public function setProcessDefinitionId($processDefinitionId)
    {
        $this->processDefinitionId = $processDefinitionId;

        return $this;
    }

    /**
     * Get process definition id
     *
     * @return string
     */
    public function getProcessDefinitionId()
    {
        return $this->processDefinitionId;
    }

    # endregion
}
