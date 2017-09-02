<?php

namespace Ds\Component\Camunda\Model\Attribute;

use stdClass;

/**
 * Trait Variables
 *
 * @package Ds\Component\Camunda
 */
trait Variables
{
    /**
     * @var \stdClass
     */
    protected $variables; # region accessors

    /**
     * Set variables
     *
     * @param \stdClass $variables
     * @return object
     */
    public function setVariables(stdClass $variables)
    {
        $this->variables = $variables;

        return $this;
    }

    /**
     * Get variables
     *
     * @return \stdClass
     */
    public function getVariables()
    {
        return $this->variables;
    }

    # endregion
}
