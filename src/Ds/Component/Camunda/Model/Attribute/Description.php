<?php

namespace Ds\Component\Camunda\Model\Attribute;

/**
 * Trait Description
 *
 * @package Ds\Component\Camunda
 */
trait Description
{
    /**
     * @var string
     */
    protected $description; # region accessors

    /**
     * Set description
     *
     * @param string $description
     * @return object
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    # endregion
}
