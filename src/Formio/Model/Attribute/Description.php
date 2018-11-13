<?php

namespace Ds\Component\Formio\Model\Attribute;

/**
 * Trait Description
 *
 * @package Ds\Component\Formio
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
