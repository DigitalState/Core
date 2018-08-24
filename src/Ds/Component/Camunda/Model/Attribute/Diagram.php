<?php

namespace Ds\Component\Camunda\Model\Attribute;

/**
 * Trait Diagram
 *
 * @package Ds\Component\Camunda
 */
trait Diagram
{
    /**
     * @var string
     */
    protected $diagram; # region accessors

    /**
     * Set diagram
     *
     * @param string $diagram
     * @return object
     */
    public function setDiagram($diagram)
    {
        $this->diagram = $diagram;

        return $this;
    }

    /**
     * Get diagram
     *
     * @return string
     */
    public function getDiagram()
    {
        return $this->diagram;
    }

    # endregion
}
