<?php

namespace Ds\Component\Security\Resolver\Context;

use DomainException;
use Ds\Component\Api\Api\Api;
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
     * @const string
     */
    const PATTERN = '/^ds\[identity\]\.(.+)/';

    /**
     * @var \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface
     */
    protected $tokenStorage;

    /**
     * @var \Ds\Component\Api\Api\Api
     */
    protected $api;

    /**
     * Constructor
     *
     * @param \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface $tokenStorage
     * @param \Ds\Component\Api\Api\Api $api
     */
    public function __construct(TokenStorageInterface $tokenStorage, Api $api)
    {
        $this->tokenStorage = $tokenStorage;
        $this->api = $api;
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

        if (!preg_match(static::PATTERN, $variable, $matches)) {
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

        switch ($user->getIdentity()) {
            case Identity::ANONYMOUS:
                $model = $this->api->get('identities.anonymous')->get($user->getIdentityUuid());
                break;

            case Identity::INDIVIDUAL:
                $model = $this->api->get('identities.individual')->get($user->getIdentityUuid());
                break;

            case Identity::ORGANIZATION:
                $model = $this->api->get('identities.organization')->get($user->getIdentityUuid());
                break;

            case Identity::STAFF:
                $model = $this->api->get('identities.staff')->get($user->getIdentityUuid());
                break;

            case Identity::SYSTEM:
                $model = $this->api->get('identities.system')->get($user->getIdentityUuid());
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
