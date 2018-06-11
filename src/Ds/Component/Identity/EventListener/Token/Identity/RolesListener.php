<?php

namespace Ds\Component\Identity\EventListener\Token\Identity;

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
    public function __construct($property = '[identity][roles]')
    {
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
        $this->accessor->setValue($data, $this->property, []);
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
