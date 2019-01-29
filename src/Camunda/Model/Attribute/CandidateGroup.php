<?php

namespace Ds\Component\Camunda\Model\Attribute;

/**
 * Trait CandidateGroup
 *
 * @package Ds\Component\Camunda
 */
trait CandidateGroup
{
    /**
     * @var string
     */
    private $candidateGroup; # region accessors

    /**
     * Set candidate group
     *
     * @param string $candidateGroup
     * @return object
     */
    public function setCandidateGroup(?string $candidateGroup)
    {
        $this->candidateGroup = $candidateGroup;

        return $this;
    }

    /**
     * Get candidate group
     *
     * @return string
     */
    public function getCandidateGroup(): ?string
    {
        return $this->candidateGroup;
    }

    # endregion
}
