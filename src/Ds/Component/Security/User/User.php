<?php

namespace Ds\Component\Security\User;

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
        return new static(
            $username,
            $payload['uuid'] ?? null,
            $payload['roles'] ?? [],
            $payload['identity'] ?? null,
            $payload['identityUuid'] ?? null
        );
    }

    /**
     * @var string
     */
    protected $username;

    /**
     * @var string
     */
    protected $uuid;

    /**
     * @var array
     */
    protected $roles;

    /**
     * @var string
     */
    protected $identity;

    /**
     * @var string
     */
    protected $identityUuid;

    /**
     * Constructor
     *
     * @param string $username
     * @param string $uuid
     * @param array $roles
     * @param string $identity
     * @param string $identityUuid
     */
    public function __construct($username, $uuid = null, array $roles = [], $identity = null, $identityUuid = null)
    {
        $this->username = $username;
        $this->uuid = $uuid;
        $this->roles = $roles;
        $this->identity = $identity;
        $this->identityUuid = $identityUuid;
    }

    /**
     * {@inheritdoc}
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * {@inheritdoc}
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * {@inheritdoc}
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * {@inheritdoc}
     */
    public function getIdentity()
    {
        return $this->identity;
    }

    /**
     * {@inheritdoc}
     */
    public function getIdentityUuid()
    {
        return $this->identityUuid;
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
