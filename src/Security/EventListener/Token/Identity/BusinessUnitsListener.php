<?php

namespace Ds\Component\Security\EventListener\Token\Identity;

use DomainException;
use Ds\Component\Api\Api\Api;
use Ds\Component\Security\Model\Identity;
use Ds\Component\Security\Model\User;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTDecodedEvent;
use Symfony\Component\PropertyAccess\PropertyAccess;
use UnexpectedValueException;

/**
 * Class BusinessUnitsListener
 *
 * @package Ds\Component\Security
 */
final class BusinessUnitsListener
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
    public function __construct(Api $api, string $property = '[identity][business_units]')
    {
        $this->api = $api;
        $this->accessor = PropertyAccess::createPropertyAccessor();
        $this->property = $property;
    }

    /**
     * Add the identity business units to the token
     *
     * @param \Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent $event
     * @throws \Ds\Component\Security\Exception\InvalidUserTypeException
     */
    public function created(JWTCreatedEvent $event)
    {
        $data = $event->getData();
        $user = $event->getUser();
        $businessUnits = [];

        // @todo remove condition when both user types are homogenized
        if ($user instanceof User) {
            $businessUnits = $user->getIdentity()->getBusinessUnits();
        } else {
            if (null !== $user->getIdentityUuid()) {
                switch ($user->getIdentity()) {
                    case Identity::ANONYMOUS:
                    case Identity::INDIVIDUAL:
                    case Identity::ORGANIZATION:
                    case Identity::SYSTEM:
                        $businessUnits = [];
                        break;

                    case Identity::STAFF:
                        $identity = $this->api->get('identities.staff')->get($user->getIdentityUuid());

                        if (!$identity) {
                            throw new UnexpectedValueException;
                        }

                        foreach ($identity->getBusinessUnits() as $businessUnit) {
                            $businessUnits[] = $businessUnit->getUuid();
                        }

                        break;

                    default:
                        throw new DomainException('User identity is not valid.');
                }
            }
        }

        $this->accessor->setValue($data, $this->property, $businessUnits);
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
