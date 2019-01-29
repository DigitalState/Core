<?php

namespace Ds\Component\Model\Attribute\Accessor;

/**
 * Trait Action
 *
 * @package Ds\Component\Model
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
