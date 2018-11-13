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
    private $definitionId; # region accessors

    /**
     * Set definition id
     *
     * @param string $definitionId
     * @return object
     */
    public function setDefinitionId(?string $definitionId)
    {
        $this->definitionId = $definitionId;

        return $this;
    }

    /**
     * Get definition id
     *
     * @return string
     */
    public function getDefinitionId(): ?string
    {
        return $this->definitionId;
    }

    # endregion
}
