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
     * @return \Ds\Component\Model\Type\CustomIdentifiable
     */
    public function setCustomId(string $customId): CustomIdentifiable;

    /**
     * Get custom id
     *
     * @return string
     */
    public function getCustomId(): ?string;
}
