<?php

namespace Ds\Component\Formio\Model\Attribute;

/**
 * Trait Password
 *
 * @package Ds\Component\Formio
 */
trait Password
{
    /**
     * @var string
     */
    private $password; # region accessors

    /**
     * Set password
     *
     * @param string $password
     * @return object
     */
    public function setPassword(?string $password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    # endregion
}
