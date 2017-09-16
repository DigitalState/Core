<?php

namespace Ds\Component\Security\Resolver\Context;

use DomainException;
use Ds\Component\Api\Api\Factory;
use Ds\Component\Identity\Identity;
use Ds\Component\Resolver\Exception\UnresolvedException;
use Ds\Component\Resolver\Resolver\Resolver;
use Exception;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Class IdentityResolver
 *
 * @package Ds\Component\Security
 */
class IdentityResolver implements Resolver
{
    /**
     * @var \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface
     */
    protected $tokenStorage;

    /**
     * \Ds\Component\Api\Api\Factory
     */
    protected $factory;

    /**
     * @var \Ds\Component\Api\Api\Api
     */
    protected $api;

    /**
     * Constructor
     *
     * @param \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface $tokenStorage
     * @param \Ds\Component\Api\Api\Factory $factory
     */
    public function __construct(TokenStorageInterface $tokenStorage, Factory $factory)
    {
        $this->tokenStorage = $tokenStorage;
        $this->factory = $factory;
    }

    /**
     * {@inheritdoc}
     */
    public function isMatch($variable, array &$matches = [])
    {
        $token = $this->tokenStorage->getToken();

        if (!$token) {
            return false;
        }

        if (!preg_match('/^ds\[identity\]\.(.+)/', $variable, $matches)) {
            return false;
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function resolve($variable)
    {
        $matches = [];

        if (!$this->isMatch($variable, $matches)) {
            throw new UnresolvedException('Variable pattern is not valid.');
        }

        $token = $this->tokenStorage->getToken();
        $user = $token->getUser();

        if (!$this->api) {
            $this->api = $this->factory->create();
        }

        switch ($user->getIdentity()) {
            case Identity::ANONYMOUS:
                $model = $this->api->identities->anonymous->get($user->getIdentityUuid());
                break;

            case Identity::INDIVIDUAL:
                $model = $this->api->identities->individual->get($user->getIdentityUuid());
                break;

            case Identity::STAFF:
                $model = $this->api->identities->staff->get($user->getIdentityUuid());
                break;

            case Identity::SYSTEM:
                $model = $this->api->identities->system->get($user->getIdentityUuid());
                break;

            default:
                throw new DomainException('User identity is not valid.');
        }

        if (!$model) {
            throw new UnresolvedException('Variable pattern did not resolve to data.');
        }

        $property = $matches[1];
        $accessor = PropertyAccess::createPropertyAccessor();

        try {
            $value = $accessor->getValue($model, $property);
        } catch (Exception $exception) {
            throw new UnresolvedException('Variable pattern did not resolve to data.', 0, $exception);
        }

        return $value;
    }
}
