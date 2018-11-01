<?php

namespace Ds\Component\Model\Attribute\Accessor;

/**
 * Trait CustomId
 *
 * @package Ds\Component\Model
 */
trait CustomId
{
    /**
     * Set custom id
     *
     * @param string $customId
     * @return object
     */
    public function setCustomId(?string $customId)
    {
        $this->customId = $customId;

        return $this;
    }

    /**
     * Get custom id
     *
     * @return string
     */
    public function getCustomId(): ?string
    {
        return $this->customId;
    }
}
