<?php

namespace Ds\Component\Identity\Resolver\Context;

use DomainException;
use Ds\Component\Api\Api\Api;
use Ds\Component\Security\Model\Identity;
use Ds\Component\Resolver\Exception\UnresolvedException;
use Ds\Component\Resolver\Resolver\Resolver;
use Exception;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Class IdentityResolver
 *
 * @package Ds\Component\Identity
 */
final class IdentityResolver implements Resolver
{
    /**
     * @const string
     */
    const PATTERN = '/^ds\[identity\]\.(.+)/';

    /**
     * @var \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * @var \Ds\Component\Api\Api\Api
     */
    private $api;

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
    public function isMatch(string $variable, array &$matches = []): bool
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
    public function resolve(string $variable)
    {
        $matches = [];

        if (!$this->isMatch($variable, $matches)) {
            throw new UnresolvedException('Variable pattern is not valid.');
        }

        $token = $this->tokenStorage->getToken();
        $user = $token->getUser();
        $identity = $user->getIdentity();

        switch ($identity->getType()) {
            case Identity::ANONYMOUS:
                $model = $this->api->get('identities.anonymous')->get($identity->getUuid());
                break;

            case Identity::INDIVIDUAL:
                $model = $this->api->get('identities.individual')->get($identity->getUuid());
                break;

            case Identity::ORGANIZATION:
                $model = $this->api->get('identities.organization')->get($identity->getUuid());
                break;

            case Identity::STAFF:
                $model = $this->api->get('identities.staff')->get($identity->getyUuid());
                break;

            case Identity::SYSTEM:
                $model = $this->api->get('identities.system')->get($identity->getUuid());
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
