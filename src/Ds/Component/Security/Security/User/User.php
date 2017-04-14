<?php

namespace Ds\Component\Security\Security\User;

use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Security\User\JWTUserInterface;

/**
 * Class User
 */
class User implements AdvancedUserInterface, JWTUserInterface
{
    /**
     * {@inheritdoc}
     */
    public static function createFromPayload($username, array $payload)
    {
        return new static($username, $payload['roles']);
    }

    /**
     * @var string
     */
    protected $username; # region accessors

    /**
     * {@inheritdoc}
     */
    public function getUsername()
    {
        return $this->username;
    }

    # endregion

    /**
     * @var array
     */
    protected $roles; # region accessors

    /**
     * {@inheritdoc}
     */
    public function getRoles()
    {
        return $this->roles;
    }

    # endregion

    /**
     * Constructor
     *
     * @param string $username
     * @param array $roles
     */
    public function __construct($username, array $roles = [])
    {
        $this->username = $username;
        $this->roles = $roles;
    }

    /**
     * {@inheritdoc}
     */
    public function getPassword()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function getSalt()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function eraseCredentials()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function isAccountNonExpired()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function isAccountNonLocked()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function isCredentialsNonExpired()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function isEnabled()
    {
        return true;
    }
}
