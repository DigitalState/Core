<?php

namespace Ds\Component\Security\Resolver\Context;

use Ds\Component\Api\Query\IndividualPersonaParameters as Parameters;
use Ds\Component\Api\Api\Factory;
use Ds\Component\Identity\Identity;
use Ds\Component\Resolver\Exception\UnresolvedException;
use Ds\Component\Resolver\Resolver\Resolver;
use Exception;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Class IndividualResolver
 *
 * @package Ds\Component\Security
 */
class IndividualResolver implements Resolver
{
    /**
     * \Ds\Component\Api\Api\Factory
     */
    protected $factory;

    /**
     * @var \Ds\Component\Api\Api\Api
     */
    protected $api;

    /**
     * @var \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface
     */
    protected $tokenStorage;

    /**
     * Constructor
     *
     * @param \Ds\Component\Api\Api\Factory $factory
     * @param \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface $tokenStorage
     */
    public function __construct(Factory $factory, TokenStorageInterface $tokenStorage)
    {
        $this->factory = $factory;
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * {@inheritdoc}
     */
    public function isMatch($variable, array &$matches = [])
    {
        if (!preg_match('/^ds\[individual\]\.persona\.(.+)/', $variable, $matches)) {
            return false;
        }

        $token = $this->tokenStorage->getToken();

        if (!$token) {
            return false;
        }

        $user = $token->getUser();

        if (Identity::INDIVIDUAL !== $user->getIdentity()) {
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
        $parameters = new Parameters;
        $parameters->setIndividualUuid($user->getIdentityUuid());

        if (!$this->api) {
            $this->api = $this->factory->create();
        }

        $models = $this->api->identities->individualPersona->getList($parameters);

        if (!$models) {
            throw new UnresolvedException('Variable pattern did not resolve to data.');
        }

        $model = array_shift($models);
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
