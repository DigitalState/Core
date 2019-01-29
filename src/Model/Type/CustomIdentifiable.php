<?php

namespace Ds\Component\Model\Type;

/**
 * Interface CustomIdentifiable
 *
 * @package Ds\Component\Model
 */
interface CustomIdentifiable
{
    /**
     * Set custom id
     *
     * @param string $customId
     */
    public function setCustomId(?string $customId);

    /**
     * Get custom id
     *
     * @return string
     */
    public function getCustomId(): ?string;
}
