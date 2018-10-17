<?php

namespace Ds\Component\Camunda\Model\Attribute;

use Ds\Component\Camunda\Model\Variable;
use OutOfRangeException;

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
    protected $variables; # region accessors

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
        $this->variables[$variable->getName()] = $variable;

        return $this;
    }

    /**
     * Get variables
     *
     * @param string $name
     * @return array
     * @throws \OutOfRangeException
     */
    public function getVariables($name = null)
    {
        if (null === $name) {
            return $this->variables;
        }

        if (!array_key_exists($name, $this->variables)) {
            throw new OutOfRangeException('Variable does not exist.');
        }

        return $this->variables[$name];
    }

    # endregion
}
