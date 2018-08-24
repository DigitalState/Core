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
