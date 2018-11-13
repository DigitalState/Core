<?php

namespace Ds\Component\Formio\Model\Attribute;

/**
 * Trait Roles
 *
 * @package Ds\Component\Formio
 */
trait Roles
{
    /**
     * @var array
     */
    private $roles; # region accessors

    /**
     * Set roles
     *
     * @param array $roles
     * @return object
     */
    public function setRoles(array $roles)
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Get roles
     *
     * @return array
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    # endregion
}
