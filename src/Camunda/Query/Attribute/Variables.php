<?php

namespace Ds\Component\Camunda\Query\Attribute;

use Ds\Component\Camunda\Model\Variable;

/**
 * Trait Variables
 *
 * @package Ds\Component\Camunda
 */
trait Variables
{
    /**
     * @var array
     */
    private $variables; # region accessors

    /**
     * Set variables
     *
     * @param array $variables
     * @return object
     */
    public function setVariables(array $variables)
    {
        $this->variables = [];

        foreach ($variables as $variable) {
            $this->addVariable($variable);
        }

        return $this;
    }

    /**
     * Add variable
     *
     * @param \Ds\Component\Camunda\Model\Variable $variable
     * @return object
     */
    public function addVariable(Variable $variable)
    {
        $this->variables[] = $variable;
        $this->_variables = true;

        return $this;
    }

    /**
     * Get variables
     *
     * @return array
     */
    public function getVariables(): array
    {
        return $this->variables;
    }

    # endregion

    /**
     * @var boolean
     */
    private $_variables;
}
