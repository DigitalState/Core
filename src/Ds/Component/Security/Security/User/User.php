<?php

namespace Ds\Component\Security\Security\User;

use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class User
 */
class User implements UserInterface
{
    /**
     * {@inheritdoc}
     */
    public function getRoles()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getPassword()
    {
        return '';
    }

    /**
     * {@inheritdoc}
     */
    public function getSalt()
    {
        return '';
    }

    /**
     * {@inheritdoc}
     */
    public function getUsername()
    {
        return '';
    }

    /**
     * {@inheritdoc}
     */
    public function getUuid()
    {
        return '';
    }

    /**
     * {@inheritdoc}
     */
    public function eraseCredentials()
    {

    }
}
