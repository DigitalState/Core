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
    private $description; # region accessors

    /**
     * Set description
     *
     * @param string $description
     * @return object
     */
    public function setDescription(?string $description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    # endregion
}
