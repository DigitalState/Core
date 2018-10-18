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
     * @return \Ds\Component\Model\Type\Uuidentifiable
     */
    public function setUuid(string $uuid): Uuidentifiable;

    /**
     * Get uuid
     *
     * @return string
     */
    public function getUuid(): ?string;
}
