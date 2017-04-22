<?php

namespace Ds\Component\Model\Type;

/**
 * Interface Uuidentifiable
 */
interface Uuidentifiable
{
    /**
     * Set uuid
     *
     * @param string $uuid
     * @return object
     */
    public function setUuid($uuid);

    /**
     * Get uuid
     *
     * @return string
     */
    public function getUuid();
}
