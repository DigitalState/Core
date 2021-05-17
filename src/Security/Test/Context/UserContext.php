<?php

namespace Ds\Component\Security\Test\Context;

use Behat\Behat\Context\Context;
use Behatch\HttpCall\Request;
use DomainException;
use Ds\Component\Security\Test\Collection\UserCollection;
use Ds\Component\Security\Model\User;
use Ds\Component\Security\Model\Identity;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use ReflectionClass;

/**
 * Class UserContext
 *
 * @package Ds\Component\Security
 */
final class UserContext implements Context
{
    /**
     * @var \Behatch\HttpCall\Request
     */
    private $request;

    /**
     * @var \Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface
     */
    private $tokenManager;

    /**
     * @var \Ds\Component\Security\Test\Collection\UserCollection
     */
    private $userCollection;

    /**
     * Constructor
     *
     * @param \Behatch\HttpCall\Request $request
     * @param \Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface $tokenManager
     * @param \Ds\Component\Security\Test\Collection\UserCollection $userCollection
     */
    public function __construct(Request $request, JWTTokenManagerInterface $tokenManager, UserCollection $userCollection)
    {
        $this->request = $request;
        $this->tokenManager = $tokenManager;
        $this->userCollection = $userCollection;
    }

    /**
     * Set authorization header with a given user from a tenant
     *
     * @Given I am authenticated as the :username user from the tenant :tenant
     * @param string $username
     * @param string $tenant
     */
    public function iAmAuthenticatedAsTheUserFromTheTenant(string $username, string $tenant)
    {
        $user = $this->userCollection->filter(function(User $user) use ($username, $tenant) {
            return $user->getUsername() === $username && $user->getTenant() === $tenant;
        })->first();

        if (!$user) {
            throw new DomainException('User "'.$username.'" for tenant "'.$tenant.'" does not exist.');
        }

        $token = $this->tokenManager->create($user);
        $this->request->setHttpHeader('Authorization', 'Bearer '.$token);
    }

    /**
     * Set authorization header with a given user and identity role from a tenant
     *
     * @Given I am authenticated as the :username user with identity role :role from the tenant :tenant
     * @param string $username
     * @param string $role
     * @param string $tenant
     */
    public function iAmAuthenticatedAsTheUserWithIdentityRoleFromTheTenant(string $username, string $role, string $tenant)
    {
        $user = $this->userCollection->filter(function(User $user) use ($username, $tenant) {
            return $user->getUsername() === $username && $user->getTenant() === $tenant;
        })->first();

        if (!$user) {
            throw new DomainException('User "'.$username.'" for tenant "'.$tenant.'" does not exist.');
        }

        $clone = clone $user;
        $identity = $clone->getIdentity();
        $class = new ReflectionClass(Identity::class);
        $property = $class->getProperty('roles');
        $property->setAccessible(true);
        $property->setValue($identity, [$role => []]);
        $property->setAccessible(false);
        $token = $this->tokenManager->create($clone);
        $this->request->setHttpHeader('Authorization', 'Bearer '.$token);
    }
}
