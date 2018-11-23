<?php

namespace Ds\Component\Security\Test\Context;

use Behat\Behat\Context\Context;
use Behatch\HttpCall\Request;
use DomainException;
use Ds\Component\Security\Test\Collection\UserCollection;
use Ds\Component\Security\Model\User;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;

/**
 * Class UserContext
 *
 * @package Ds\Component\Security
 */
class UserContext implements Context
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
     * @var \Ds\Component\Security\Test\Collection\UserCollection
     */
    protected $userCollection;

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
     * Set authorization header
     *
     * @Given I am authenticated as the :user user from the tenant :tenant
     * @param string $identity
     * @param string $tenant
     */
    public function iAmAuthenticatedAsTheUserFromTheTenant($identity, $tenant)
    {
        $user = $this->userCollection->filter(function(User $user) use ($identity, $tenant) {
            return $user->getIdentity()->getType() === $identity && $user->getTenant() === $tenant;
        })->first();

        if (!$user) {
            throw new DomainException('User does not exist.');
        }

        $token = $this->tokenManager->create($user);
        var_dump($token);exit;
        $this->request->setHttpHeader('Authorization', 'Bearer '.$token);
    }
}
