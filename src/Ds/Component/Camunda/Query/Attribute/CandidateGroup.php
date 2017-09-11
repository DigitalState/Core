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
    protected $candidateGroup; # region accessors

    /**
     * Set candidate group
     *
     * @param string $candidateGroup
     * @return object
     */
    public function setCandidateGroup($candidateGroup)
    {
        $this->candidateGroup = $candidateGroup;
        $this->_candidateGroup = true;

        return $this;
    }

    /**
     * Get candidateGroup
     *
     * @return string
     */
    public function getCandidateGroup()
    {
        return $this->candidateGroup;
    }

    # endregion

    /**
     * @var boolean
     */
    protected $_candidateGroup;
}
