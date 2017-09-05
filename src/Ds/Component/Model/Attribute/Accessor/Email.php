<?php

namespace Ds\Component\Model\Attribute\Accessor;

/**
 * Trait Email
 *
 * @package Ds\Component\Model
 */
trait Email
{
    /**
     * Set email
     *
     * @param string $email
     * @return object
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }
}
