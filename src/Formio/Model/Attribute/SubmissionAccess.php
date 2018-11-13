<?php

namespace Ds\Component\Formio\Model\Attribute;

/**
 * Trait SubmissionAccess
 *
 * @package Ds\Component\Formio
 */
trait SubmissionAccess
{
    /**
     * @var array
     */
    private $submissionAccess; # region accessors

    /**
     * Set submission access
     *
     * @param array $submissionAccess
     * @return object
     */
    public function setSubmissionAccess(array $submissionAccess)
    {
        $this->submissionAccess = $submissionAccess;

        return $this;
    }

    /**
     * Get submission access
     *
     * @return array
     */
    public function getSubmissionAccess(): array
    {
        return $this->submissionAccess;
    }

    # endregion
}
