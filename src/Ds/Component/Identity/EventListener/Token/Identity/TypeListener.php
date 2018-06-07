<?php

namespace Ds\Component\Identity\EventListener\Token\Identity;

use Ds\Component\Security\Model\User;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTDecodedEvent;
use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * Class TypeListener
 *
 * @package Ds\Component\Identity
 */
class TypeListener
{
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
     * @param string $property
     */
    public function __construct($property = '[identity][type]')
    {
        $this->accessor = PropertyAccess::createPropertyAccessor();
        $this->property = $property;
    }

    /**
     * Add the identity type to the token
     *
     * @param \Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent $event
     * @throws \Ds\Component\Security\Exception\InvalidUserTypeException
     */
    public function created(JWTCreatedEvent $event)
    {
        $data = $event->getData();
        $user = $event->getUser();

        // @todo Standardize interface between app user entity and security user model
        if ($user instanceof User) {
            $this->accessor->setValue($data, $this->property, $user->getIdentity()->getType());
        } else {
            $this->accessor->setValue($data, $this->property, $user->getIdentity());
        }

        $event->setData($data);
    }

    /**
     * Mark the token as invalid if the identity type is missing
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
