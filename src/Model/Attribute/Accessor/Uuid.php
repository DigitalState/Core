<?php

namespace Ds\Component\Model\Attribute\Accessor;

use InvalidArgumentException;

/**
 * Trait Uuid
 *
 * @package Ds\Component\Model
 */
trait Uuid
{
    /**
     * Set uuid
     *
     * @param string $uuid
     * @return object
     * @throws \InvalidArgumentException
     */
    public function setUuid(?string $uuid)
    {
        if (null !== $uuid) {
            if (!preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i', $uuid)) {
                throw new InvalidArgumentException('Uuid is not valid.');
            }
        }

        $this->uuid = $uuid;

        return $this;
    }

    /**
     * Get uuid
     *
     * @return string
     */
    public function getUuid(): ?string
    {
        return $this->uuid;
    }
}
