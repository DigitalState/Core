<?php

namespace Ds\Component\Model\Type;

/**
 * Interface Uuidentifiable
 *
 * @package Ds\Component\Model
 */
interface Uuidentifiable
{
    /**
     * Set uuid
     *
     * @param string $uuid
     */
    public function setUuid(?string $uuid);

    /**
     * Get uuid
     *
     * @return string
     */
    public function getUuid(): ?string;
}
