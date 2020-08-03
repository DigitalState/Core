<?php

namespace Ds\Component\Security\Model;

use Symfony\Component\Security\Core\User\UserInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Security\User\JWTUserInterface;

/**
 * Class User
 *
 * @package Ds\Component\Security
 */
final class User implements UserInterface, JWTUserInterface
{
    /**
     * {@inheritdoc}
     */
    public static function createFromPayload($username, array $payload)
    {
        // @todo Populate security user model using callbacks from JWT token event listeners, instead of hard-coded here
        $uuid = $payload['uuid'] ?? null;
        $roles = $payload['roles'] ?? [];
        $identity = new Identity;
        $identity->setRoles((array) array_key_exists('identity', $payload) && property_exists($payload['identity'], 'roles') ? $payload['identity']->roles : []);
        $identity->setBusinessUnits((array) array_key_exists('identity', $payload) && property_exists($payload['identity'], 'business_units') ? $payload['identity']->business_units : []);
        $identity->setType(array_key_exists('identity', $payload) && property_exists($payload['identity'], 'type') ? $payload['identity']->type : null);
        $identity->setUuid(array_key_exists('identity', $payload) && property_exists($payload['identity'], 'uuid') ? $payload['identity']->uuid : null);
        $tenant = $payload['tenant'] ?? null;

        return new static($username, $uuid, $roles, $identity, $tenant);
    }

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $uuid;

    /**
     * @var array
     */
    private $roles;

    /**
     * @var \Ds\Component\Security\Model\Identity
     */
    private $identity;

    /**
     * @var string
     */
    private $tenant;

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
