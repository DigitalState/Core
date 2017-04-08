<?php

namespace Ds\Component\Entity\Entity;

/**
 * Interface Handleable
 */
interface Handleable
{
    /**
     * Set handler
     *
     * @param string $handler
     * @return object
     */
    public function setHandler($handler);

    /**
     * Get handler
     *
     * @return string
     */
    public function getHandler();

    /**
     * Set handler uuid
     *
     * @param string $handlerUuid
     * @return object
     */
    public function setHandlerUuid($handlerUuid);

    /**
     * Get handler uuid
     *
     * @return string
     */
    public function getHandlerUuid();
}
