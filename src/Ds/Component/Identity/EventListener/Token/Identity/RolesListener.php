<?php

namespace Ds\Component\Identity\EventListener\Token\Identity;

use AppBundle\Entity\User;
use DomainException;
use Ds\Component\Api\Api\Api;
use Ds\Component\Identity\Model\Identity;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTDecodedEvent;
use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * Class RolesListener
 *
 * @package Ds\Component\Identity
 */
class RolesListener
{
    /**
     * @var \Ds\Component\Api\Api\Api
     */
    protected $api;

    /**
     * @var \Symfony\Component\PropertyAccess\PropertyAccessor
     */
    protected $accessor;

    /**
     * @var string
     */
    protected $property;

    /**
     * Constructor
     *
     * @param \Ds\Component\Api\Api\Api $api
     * @param string $property
     */
    public function __construct(Api $api, $property = '[identity][roles]')
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
            switch ($user->getIdentity()) {
                case Identity::ANONYMOUS:
                    $identity = $this->api->get('identities.anonymous')->get($user->getIdentityUuid());
                    break;

                case Identity::INDIVIDUAL:
                    $identity = $this->api->get('identities.individual')->get($user->getIdentityUuid());
                    break;

                case Identity::ORGANIZATION:
                    $identity = $this->api->get('identities.organization')->get($user->getIdentityUuid());
                    break;

                case Identity::STAFF:
                    $identity = $this->api->get('identities.staff')->get($user->getIdentityUuid());
                    break;

                case Identity::SYSTEM:
                    $identity = $this->api->get('identities.system')->get($user->getIdentityUuid());
                    break;

                default:
                    throw new DomainException('User identity is not valid.');
            }

            foreach ($identity->getRoles() as $role) {
                // @todo Remove substr once we remove iri-based api foreign keys
                $roles[] = substr($role, -36);
            }
        } else {
            $roles = $user->getIdentity()->getRoles();
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

        if (!$this->accessor->isReadable($payload, $this->property)) {
            $event->markAsInvalid();
        }
    }
}
