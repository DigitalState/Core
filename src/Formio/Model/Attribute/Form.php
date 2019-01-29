<?php

namespace Ds\Component\Formio\Model\Attribute;

/**
 * Trait Form
 *
 * @package Ds\Component\Formio
 */
trait Form
{
    /**
     * @var string
     */
    private $form; # region accessors

    /**
     * Set form
     *
     * @param string $form
     * @return object
     */
    public function setForm(?string $form)
    {
        $this->form = $form;

        return $this;
    }

    /**
     * Get form
     *
     * @return string
     */
    public function getForm(): ?string
    {
        return $this->form;
    }

    # endregion
}
