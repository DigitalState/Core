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
     * @return object
     */
    public function setCustomId($customId);

    /**
     * Get custom id
     *
     * @return string
     */
    public function getCustomId();
}
