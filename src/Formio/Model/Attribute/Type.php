<?php

namespace Ds\Component\Formio\Model\Attribute;

/**
 * Trait Type
 *
 * @package Ds\Component\Formio
 */
trait Type
{
    /**
     * @var string
     */
    private $type; # region accessors

    /**
     * Set type
     *
     * @param string $type
     * @return object
     */
    public function setType(?string $type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    # endregion
}
