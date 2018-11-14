<?php

namespace Ds\Component\Security\Model;

use Ds\Component\Security\Model\Identity;
use Symfony\Component\Security\Core\User\UserInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Security\User\JWTUserInterface;

/**
 * Class User
 *
 * @package Ds\Component\Security
 */
class User implements UserInterface, JWTUserInterface
{
    /**
     * {@inheritdoc}
     */
    public static function createFromPayload($username, array $payload)
    {
        $uuid = $payload['uuid'] ?? null;
        $roles = $payload['roles'] ?? [];
        $identity = new Identity;
        $identity->setRoles($payload['identity']['roles'] ?? []);
        $identity->setType($payload['identity']['type'] ?? null);
        $identity->setUuid($payload['identity']['uuid'] ?? null);
        $tenant = $payload['tenant'] ?? null;

        return new static($username, $uuid, $roles, $identity, $tenant);
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
     * @var \Ds\Component\Security\Model\Identity
     */
    protected $identity;

    /**
     * @var string
     */
    protected $tenant;

    /**
     * Constructor
     *
     * @param string $username
     * @param string $uuid
     * @param array $roles
     * @param \Ds\Component\Security\Model\Identity $identity
     * @param string $tenant
     */
    public function __construct(string $username, string $uuid = null, array $roles = [], Identity $identity = null, string $tenant = null)
    {
        $this->username = $username;
        $this->uuid = $uuid;
        $this->roles = $roles;
        $this->identity = $identity;
        $this->tenant = $tenant;
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
    public function getTenant()
    {
        return $this->tenant;
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
}