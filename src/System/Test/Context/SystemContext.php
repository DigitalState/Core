<?php

namespace Ds\Component\System\Test\Context;

use Behat\Behat\Context\Context;
use Behatch\HttpCall\Request;
use DomainException;
use Ds\Component\System\Test\Collection\UserCollection;

/**
 * Class SystemContext
 *
 * @package Ds\Component\System
 */
class SystemContext implements Context
{
    /**
     * @var \Behatch\HttpCall\Request
     */
    protected $request;

    /**
     * @var \Ds\Component\System\Test\Collection\UserCollection
     */
    protected $userCollection;

    /**
     * Constructor
     *
     * @param \Behatch\HttpCall\Request $request
     * @param \Ds\Component\System\Test\Collection\UserCollection $userCollection
     */
    public function __construct(Request $request, UserCollection $userCollection)
    {
        $this->request = $request;
        $this->userCollection = $userCollection;
    }

    /**
     * Set authorization header
     *
     * @Given I am authenticated as the :username user
     * @param string $username
     */
    public function iAmAuthenticatedAsTheUser($username)
    {
        $user = $this->userCollection->filter(function($user) use ($username) {
            return $user['username'] === $username;
        })->first();

        if (!$user) {
            throw new DomainException('User does not exist.');
        }

        $this->request->setHttpHeader('Authorization', 'Basic '.base64_encode($user['username'].':'.$user['password']));
    }
}
