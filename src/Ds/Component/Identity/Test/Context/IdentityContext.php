<?php

namespace Ds\Component\Identity\Test\Context;

use Behat\Behat\Context\Context;
use Behatch\HttpCall\Request;
use DomainException;
use Ds\Component\Identity\Collection\UserCollection;
use Ds\Component\Security\Model\User;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;

/**
 * Class IdentityContext
 *
 * @package Ds\Component\Identity
 */
class IdentityContext implements Context
{
    /**
     * @var \Behatch\HttpCall\Request
     */
    protected $request;

    /**
     * @var \Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface
     */
    protected $tokenManager;

    /**
     * @var \Ds\Component\Identity\Collection\UserCollection
     */
    protected $userCollection;

    /**
     * Constructor
     *
     * @param \Behatch\HttpCall\Request $request
     * @param \Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface $tokenManager
     * @param \Ds\Component\Identity\Collection\UserCollection $userCollection
     */
    public function __construct(Request $request, JWTTokenManagerInterface $tokenManager, UserCollection $userCollection)
    {
        $this->request = $request;
        $this->tokenManager = $tokenManager;
        $this->userCollection = $userCollection;
    }

    /**
     * Set authorization header
     *
     * @Given I am authenticated as the :identity identity from the tenant :tenant
     * @param string $identity
     * @param string $tenant
     */
    public function iAmAuthenticatedAsTheIdentityFromTheTenant($identity, $tenant)
    {
        $user = $this->userCollection->filter(function(User $user) use ($identity, $tenant) {
            return $user->getIdentity()->getType() === $identity && $user->getTenant() === $tenant;
        })->first();

        if (!$user) {
            throw new DomainException('User does not exist.');
        }

        $token = $this->tokenManager->create($user);
        $this->request->setHttpHeader('Authorization', 'Bearer '.$token);
    }
}
