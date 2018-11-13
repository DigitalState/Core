<?php

namespace Ds\Component\Formio\Model\Attribute;

/**
 * Trait Template
 *
 * @package Ds\Component\Formio
 */
trait Template
{
    /**
     * @var string
     */
    private $template; # region accessors

    /**
     * Set template
     *
     * @param string $template
     * @return object
     */
    public function setTemplate(?string $template)
    {
        $this->template = $template;

        return $this;
    }

    /**
     * Get template
     *
     * @return string
     */
    public function getTemplate(): ?string
    {
        return $this->template;
    }

    # endregion
}
