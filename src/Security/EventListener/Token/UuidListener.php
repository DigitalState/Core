<?php

namespace Ds\Component\Security\EventListener\Token;

use Ds\Component\Security\Exception\InvalidUserTypeException;
use Ds\Component\Security\Model\User;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTDecodedEvent;
use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * Class UuidListener
 *
 * @package Ds\Component\Security
 */
final class UuidListener
{
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
     * @param string $property
     */
    public function __construct(string $property = '[uuid]')
    {
        $this->accessor = PropertyAccess::createPropertyAccessor();
        $this->property = $property;
    }

    /**
     * Add the user uuid to the token
     *
     * @param \Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent $event
     * @throws \Ds\Component\Security\Exception\InvalidUserTypeException
     */
    public function created(JWTCreatedEvent $event)
    {
        $data = $event->getData();
        $user = $event->getUser();

        if (!$user instanceof User) {
            throw new InvalidUserTypeException('Security user should be an instance of "'.User::class.'"');
        }

        $this->accessor->setValue($data, $this->property, $user->getUuid());
        $event->setData($data);
    }

    /**
     * Mark the token as invalid if the user uuid is missing
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
