<?php

namespace Ds\Component\Security\Resolver\Context\Identity;

use DomainException;
use Ds\Component\Api\Api\Factory;
use Ds\Component\Api\Query\AnonymousPersonaParameters;
use Ds\Component\Api\Query\IndividualPersonaParameters;
use Ds\Component\Api\Query\OrganizationPersonaParameters;
use Ds\Component\Api\Query\StaffPersonaParameters;
use Ds\Component\Api\Query\SystemPersonaParameters;
use Ds\Component\Identity\Identity;
use Ds\Component\Resolver\Exception\UnresolvedException;
use Ds\Component\Resolver\Resolver\Resolver;
use Exception;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Class PersonaResolver
 *
 * @package Ds\Component\Security
 */
class PersonaResolver implements Resolver
{
    /**
     * @const string
     */
    const PATTERN = '/^ds\[identity\]\.persona\.(.+)/';

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

        if (!$this->api) {
            $this->api = $this->factory->create();
        }

        switch ($user->getIdentity()) {
            case Identity::ANONYMOUS:
                $parameters = new AnonymousPersonaParameters;
                $parameters->setAnonymousUuid($user->getIdentityUuid());
                $models = $this->api->identities->anonymousPersona->getList($parameters);
                break;

            case Identity::INDIVIDUAL:
                $parameters = new IndividualPersonaParameters;
                $parameters->setIndividualUuid($user->getIdentityUuid());
                $models = $this->api->identities->individualPersona->getList($parameters);
                break;

            case Identity::ORGANIZATION:
                $parameters = new OrganizationPersonaParameters;
                $parameters->setOrganizationUuid($user->getIdentityUuid());
                $models = $this->api->identities->organizationPersona->getList($parameters);
                break;

            case Identity::STAFF:
                $parameters = new StaffPersonaParameters;
                $parameters->setStaffUuid($user->getIdentityUuid());
                $models = $this->api->identities->staffPersona->getList($parameters);
                break;

            case Identity::SYSTEM:
                $parameters = new SystemPersonaParameters;
                $parameters->setSystemUuid($user->getIdentityUuid());
                $models = $this->api->identities->systemPersona->getList($parameters);
                break;

            default:
                throw new DomainException('User identity is not valid.');
        }

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
