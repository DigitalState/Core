<?php

namespace Ds\Component\Model\Attribute\Accessor;

/**
 * Trait Form
 *
 * @package Ds\Component\Model
 */
trait Form
{
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
}
