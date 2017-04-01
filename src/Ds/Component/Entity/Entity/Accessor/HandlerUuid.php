<?php

namespace Ds\Component\Entity\Entity\Accessor;

/**
 * Trait HandlerUuid
 */
trait HandlerUuid
{
    /**
     * Set handler uuid
     *
     * @param string $handlerUuid
     * @return object
     */
    public function setHandlerUuid($handlerUuid)
    {
        $this->handlerUuid = $handlerUuid;

        return $this;
    }

    /**
     * Get handler uuid
     *
     * @return string
     */
    public function getHandlerUuid()
    {
        return $this->handlerUuid;
    }
}
