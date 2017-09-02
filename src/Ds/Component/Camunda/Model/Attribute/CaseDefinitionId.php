<?php

namespace Ds\Component\Camunda\Model\Attribute;

/**
 * Trait CaseDefinitionId
 *
 * @package Ds\Component\Camunda
 */
trait CaseDefinitionId
{
    /**
     * @var string
     */
    protected $caseDefinitionId; # region accessors

    /**
     * Set case definition id
     *
     * @param string $caseDefinitionId
     * @return object
     */
    public function setCaseDefinitionId($caseDefinitionId)
    {
        $this->caseDefinitionId = $caseDefinitionId;

        return $this;
    }

    /**
     * Get case definition id
     *
     * @return string
     */
    public function getCaseDefinitionId()
    {
        return $this->caseDefinitionId;
    }

    # endregion
}
