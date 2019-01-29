<?php

namespace Ds\Component\Camunda\Model\Attribute;

/**
 * Trait FormKey
 *
 * @package Ds\Component\Camunda
 */
trait FormKey
{
    /**
     * @var string
     */
    private $formKey; # region accessors

    /**
     * Set form key
     *
     * @param string $formKey
     * @return object
     */
    public function setFormKey(?string $formKey)
    {
        $this->formKey = $formKey;

        return $this;
    }

    /**
     * Get form key
     *
     * @return string
     */
    public function getFormKey(): ?string
    {
        return $this->formKey;
    }

    # endregion
}
