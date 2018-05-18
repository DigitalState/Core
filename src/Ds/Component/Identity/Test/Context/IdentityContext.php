<?php

namespace Ds\Component\Identity\Test\Context;

use Behat\Behat\Context\Context;
use Behatch\HttpCall\Request;
use DomainException;
use Ds\Component\Identity\Collection\IdentityCollection;
use Ds\Component\Security\User\User;
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
     * @var \Ds\Component\Identity\Collection\IdentityCollection
     */
    protected $identityCollection;

    /**
     * Constructor
     *
     * @param \Behatch\HttpCall\Request $request
     * @param \Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface $tokenManager
     * @param \Ds\Component\Identity\Collection\IdentityCollection $identityCollection
     */
    public function __construct(Request $request, JWTTokenManagerInterface $tokenManager, IdentityCollection $identityCollection)
    {
        $this->request = $request;
        $this->tokenManager = $tokenManager;
        $this->identityCollection = $identityCollection;
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
        $element = $this->identityCollection->filter(function(User $element) use ($identity, $tenant) {
            return $element->getIdentity() === $identity && $element->getTenant() === $tenant;
        })->first();

        if (!$element) {
            throw new DomainException('Identity does not exist.');
        }

        $token = $this->tokenManager->create($element);
        $this->request->setHttpHeader('Authorization', 'Bearer '.$token);
    }
}
