<?php

namespace Ds\Component\Camunda\Model\Attribute;

/**
 * Trait CaseInstanceId
 *
 * @package Ds\Component\Camunda
 */
trait CaseInstanceId
{
    /**
     * @var string
     */
    private $caseInstanceId; # region accessors

    /**
     * Set case instance id
     *
     * @param string $caseInstanceId
     * @return object
     */
    public function setCaseInstanceId(?string $caseInstanceId)
    {
        $this->caseInstanceId = $caseInstanceId;

        return $this;
    }

    /**
     * Get case instance id
     *
     * @return string
     */
    public function getCaseInstanceId(): ?string
    {
        return $this->caseInstanceId;
    }

    # endregion
}
