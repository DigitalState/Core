<?php

namespace Ds\Component\Formio\Model\Attribute;

/**
 * Trait Name
 *
 * @package Ds\Component\Formio
 */
trait Name
{
    /**
     * @var string
     */
    private $name; # region accessors

    /**
     * Set name
     *
     * @param string $name
     * @return object
     */
    public function setName(?string $name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    # endregion
}
