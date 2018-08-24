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
    protected $password; # region accessors

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

    # endregion
}
