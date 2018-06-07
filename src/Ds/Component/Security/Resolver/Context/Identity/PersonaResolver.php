<?php

namespace Ds\Component\Security\Resolver\Context\Identity;

use DomainException;
use Ds\Component\Api\Api\Api;
use Ds\Component\Api\Query\AnonymousPersonaParameters;
use Ds\Component\Api\Query\IndividualPersonaParameters;
use Ds\Component\Api\Query\OrganizationPersonaParameters;
use Ds\Component\Api\Query\StaffPersonaParameters;
use Ds\Component\Api\Query\SystemPersonaParameters;
use Ds\Component\Identity\Model\Identity;
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
        $identity = $user->getIdentity();

        switch ($identity->getType()) {
            case Identity::ANONYMOUS:
                $parameters = new AnonymousPersonaParameters;
                $parameters->setAnonymousUuid($identity->getUuid());
                $models = $this->api->get('identities.anonymous_persona')->getList($parameters);
                break;

            case Identity::INDIVIDUAL:
                $parameters = new IndividualPersonaParameters;
                $parameters->setIndividualUuid($identity->getUuid());
                $models = $this->api->get('identities.individual_persona')->getList($parameters);
                break;

            case Identity::ORGANIZATION:
                $parameters = new OrganizationPersonaParameters;
                $parameters->setOrganizationUuid($identity->getUuid());
                $models = $this->api->get('identities.organization_persona')->getList($parameters);
                break;

            case Identity::STAFF:
                $parameters = new StaffPersonaParameters;
                $parameters->setStaffUuid($identity->getUuid());
                $models = $this->api->get('identities.staff_persona')->getList($parameters);
                break;

            case Identity::SYSTEM:
                $parameters = new SystemPersonaParameters;
                $parameters->setSystemUuid($identity->getUuid());
                $models = $this->api->get('identities.system_persona')->getList($parameters);
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
