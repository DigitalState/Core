<?php

namespace Ds\Component\Formio\Model\Attribute;

/**
 * Trait Email
 *
 * @package Ds\Component\Formio
 */
trait Email
{
    /**
     * @var string
     */
    private $email; # region accessors

    /**
     * Set email
     *
     * @param string $email
     * @return object
     */
    public function setEmail(?string $email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    # endregion
}
