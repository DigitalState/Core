<?php

namespace Ds\Component\Camunda\Model\Attribute;

/**
 * Trait DefinitionId
 *
 * @package Ds\Component\Camunda
 */
trait DefinitionId
{
    /**
     * @var string
     */
    protected $definitionId; # region accessors

    /**
     * Set definition id
     *
     * @param string $definitionId
     * @return object
     */
    public function setDefinitionId($definitionId)
    {
        $this->definitionId = $definitionId;

        return $this;
    }

    /**
     * Get definition id
     *
     * @return string
     */
    public function getDefinitionId()
    {
        return $this->definitionId;
    }

    # endregion
}
