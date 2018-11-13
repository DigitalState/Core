<?php

namespace Ds\Component\Camunda\Query\Attribute;

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
    public function setCandidateGroup(?string$candidateGroup)
    {
        $this->candidateGroup = $candidateGroup;
        $this->_candidateGroup = null !== $candidateGroup;

        return $this;
    }

    /**
     * Get candidateGroup
     *
     * @return string
     */
    public function getCandidateGroup(): ?string
    {
        return $this->candidateGroup;
    }

    # endregion

    /**
     * @var boolean
     */
    private $_candidateGroup;
}
