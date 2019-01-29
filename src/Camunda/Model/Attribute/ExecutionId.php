<?php

namespace Ds\Component\Camunda\Model\Attribute;

/**
 * Trait ExecutionId
 *
 * @package Ds\Component\Camunda
 */
trait ExecutionId
{
    /**
     * @var string
     */
    private $executionId; # region accessors

    /**
     * Set execution id
     *
     * @param string $executionId
     * @return object
     */
    public function setExecutionId(?string $executionId)
    {
        $this->executionId = $executionId;

        return $this;
    }

    /**
     * Get execution id
     *
     * @return string
     */
    public function getExecutionId(): ?string
    {
        return $this->executionId;
    }

    # endregion
}
