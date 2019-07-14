<?php

namespace Ds\Component\Security\EventListener\Token\Identity;

use DomainException;
use Ds\Component\Api\Api\Api;
use Ds\Component\Api\Query\AnonymousRoleParameters;
use Ds\Component\Api\Query\IndividualRoleParameters;
use Ds\Component\Api\Query\OrganizationRoleParameters;
use Ds\Component\Api\Query\StaffRoleParameters;
use Ds\Component\Api\Query\SystemRoleParameters;
use Ds\Component\Security\Model\Identity;
use Ds\Component\Security\Model\User;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTDecodedEvent;
use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * Class RolesListener
 *
 * @package Ds\Component\Security
 */
final class RolesListener
{
    /**
     * @var \Ds\Component\Api\Api\Api
     */
    private $api;

    /**
     * @var \Symfony\Component\PropertyAccess\PropertyAccessor
     */
    private $accessor;

    /**
     * @var string
     */
    private $property;

    /**
     * Constructor
     *
     * @param \Ds\Component\Api\Api\Api $api
     * @param string $property
     */
    public function __construct(Api $api, string $property = '[identity][roles]')
    {
        $this->api = $api;
        $this->accessor = PropertyAccess::createPropertyAccessor();
        $this->property = $property;
    }

    /**
     * Add the identity roles to the token
     *
     * @param \Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent $event
     * @throws \Ds\Component\Security\Exception\InvalidUserTypeException
     */
    public function created(JWTCreatedEvent $event)
    {
        $data = $event->getData();
        $user = $event->getUser();
        $roles = [];

        // @todo remove condition when both user types are homogenized
        if ($user instanceof User) {
            $roles = $user->getIdentity()->getRoles();
        } else {
            if (null !== $user->getIdentityUuid()) {
                switch ($user->getIdentity()) {
                    case Identity::ANONYMOUS:
                        $parameters = new AnonymousRoleParameters;
                        $parameters->setAnonymousUuid($user->getIdentityUuid());
                        $identityRoles = $this->api->get('identities.anonymous_role')->getList($parameters);
                        break;

                    case Identity::INDIVIDUAL:
                        $parameters = new IndividualRoleParameters;
                        $parameters->setIndividualUuid($user->getIdentityUuid());
                        $identityRoles = $this->api->get('identities.individual_role')->getList($parameters);
                        break;

                    case Identity::ORGANIZATION:
                        $parameters = new OrganizationRoleParameters;
                        $parameters->setOrganizationUuid($user->getIdentityUuid());
                        $identityRoles = $this->api->get('identities.organization_role')->getList($parameters);
                        break;

                    case Identity::STAFF:
                        $parameters = new StaffRoleParameters;
                        $parameters->setStaffUuid($user->getIdentityUuid());
                        $identityRoles = $this->api->get('identities.staff_role')->getList($parameters);
                        break;

                    case Identity::SYSTEM:
                        $parameters = new SystemRoleParameters;
                        $parameters->setSystemUuid($user->getIdentityUuid());
                        $identityRoles = $this->api->get('identities.system_role')->getList($parameters);
                        break;

                    default:
                        throw new DomainException('User identity is not valid.');
                }

                foreach ($identityRoles as $identityRole) {
                    $role = $identityRole->getRole()->getUuid();
                    $roles[$role] = [];

                    foreach ($identityRole->getBusinessUnits() as $businessUnit) {
                        $roles[$role][] = $businessUnit->getUuid();
                    }
                }
            }
        }

        $this->accessor->setValue($data, $this->property, $roles);
        $event->setData($data);
    }

    /**
     * Mark the token as invalid if the identity roles is missing
     *
     * @param \Lexik\Bundle\JWTAuthenticationBundle\Event\JWTDecodedEvent $event
     */
    public function decoded(JWTDecodedEvent $event)
    {
        $payload = $event->getPayload();

        // Make property accessor paths compatible by converting payload to recursive associative array
        $payload = json_decode(json_encode($payload), true);

        if (!$this->accessor->isReadable($payload, $this->property)) {
            $event->markAsInvalid();
        }
    }
}
