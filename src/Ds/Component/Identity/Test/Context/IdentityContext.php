<?php

namespace Ds\Component\Identity\Test\Context;

use Behat\Behat\Context\Context;
use Behatch\HttpCall\Request;
use DomainException;
use Ds\Component\Identity\Collection\IdentityCollection;
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
     * @Given I am authenticated as a :identity identity
     */
    public function iAmAuthenticatedAsAnIdentity($identity)
    {
        if (!$this->identityCollection->containsKey($identity)) {
            throw new DomainException('Identity does not exist.');
        }

        $identity = $this->identityCollection->get($identity);
        $token = $this->tokenManager->create($identity);
        $this->request->setHttpHeader('Authorization', 'Bearer '.$token);
    }
}
