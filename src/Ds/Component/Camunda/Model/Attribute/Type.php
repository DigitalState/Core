<?php

namespace Ds\Component\Camunda\Model\Attribute;

/**
 * Trait Type
 *
 * @package Ds\Component\Camunda
 */
trait Type
{
    /**
     * @var string
     */
    protected $type; # region accessors

    /**
     * Set type
     *
     * @param string $type
     * @return object
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    # endregion
}
