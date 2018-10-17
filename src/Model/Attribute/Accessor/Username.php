<?php

namespace Ds\Component\Model\Attribute\Accessor;

/**
 * Trait Username
 *
 * @package Ds\Component\Model
 */
trait Username
{
    /**
     * Set username
     *
     * @param string $username
     * @return object
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }
}
