<?php

namespace Ds\Component\Camunda\Query\Attribute;

/**
 * Trait CandidateGroups
 *
 * @package Ds\Component\Camunda
 */
trait CandidateGroups
{
    /**
     * @var string
     */
    private $candidateGroups; # region accessors

    /**
     * Set candidate groups
     *
     * @param string $candidateGroups
     * @return object
     */
    public function setCandidateGroups(?array $candidateGroups)
    {
        if ($candidateGroups) {
            $this->candidateGroups = $candidateGroups;
            $this->_candidateGroups = null !== $candidateGroups;
        }

        return $this;
    }

    /**
     * Get candidate groups
     *
     * @return string
     */
    public function getCandidateGroups(): ?array
    {
        return $this->candidateGroups;
    }

    # endregion

    /**
     * @var boolean
     */
    private $_candidateGroups;
}
