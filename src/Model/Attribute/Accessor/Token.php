<?php

namespace Ds\Component\Model\Attribute\Accessor;

/**
 * Trait Token
 *
 * @package Ds\Component\Model
 */
trait Token
{
    /**
     * Set token
     *
     * @param string $token
     * @return object
     */
    public function setToken(?string $token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Get token
     *
     * @return string
     */
    public function getToken(): ?string
    {
        return $this->token;
    }
}
