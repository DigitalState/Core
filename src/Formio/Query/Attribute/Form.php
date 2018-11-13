<?php

namespace Ds\Component\Formio\Query\Attribute;

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
        $this->_form = null !== $form;

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

    /**
     * @var boolean
     */
    private $_form;
}
