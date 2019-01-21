<?php

namespace Ds\Component\Form\Model\Attribute\Accessor;

/**
 * Trait Action
 *
 * @package Ds\Component\Form
 */
trait Action
{
    /**
     * Set action
     *
     * @param string $action
     * @return object
     */
    public function setAction(?string $action)
    {
        $this->action = $action;

        return $this;
    }

    /**
     * Get action
     *
     * @return string
     */
    public function getAction(): ?string
    {
        return $this->action;
    }
}
