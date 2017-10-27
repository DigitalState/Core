<?php

namespace Ds\Component\Model\Attribute\Accessor;

/**
 * Trait Password
 *
 * @package Ds\Component\Model
 */
trait Password
{
    /**
     * Set password
     *
     * @param string $password
     * @return object
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }
}
