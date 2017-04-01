<?php

namespace Ds\Component\Entity\Entity\Accessor;

/**
 * Trait Handler
 */
trait Handler
{
    /**
     * Set handler
     *
     * @param string $handler
     * @return object
     */
    public function setHandler($handler)
    {
        $this->handler = $handler;

        return $this;
    }

    /**
     * Get handler
     *
     * @return string
     */
    public function getHandler()
    {
        return $this->handler;
    }
}
