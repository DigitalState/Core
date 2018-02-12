<?php

namespace Ds\Component\Security\EventListener\Token;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTDecodedEvent;

/**
 * Class UuidListener
 *
 * @package Ds\Component\Security
 */
class UuidListener
{
    /**
     * @var string
     */
    protected $attribute;

    /**
     * Constructor
     *
     * @param string $attribute
     */
    public function __construct($attribute = 'uuid')
    {
        $this->attribute = $attribute;
    }

    /**
     * Add the user uuid to the token
     *
     * @param \Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent $event
     * @throws \Ds\Component\Security\Exception\InvalidUserTypeException
     */
    public function created(JWTCreatedEvent $event)
    {
        $payload = $event->getData();
        $user = $event->getUser();
        $payload[$this->attribute] = $user->getUuid();
        $event->setData($payload);
    }

    /**
     * Mark the token as invalid if the user uuid is missing
     *
     * @param \Lexik\Bundle\JWTAuthenticationBundle\Event\JWTDecodedEvent $event
     */
    public function decoded(JWTDecodedEvent $event)
    {
        $payload = $event->getPayload();

        if (!array_key_exists($this->attribute, $payload)) {
            $event->markAsInvalid();
        }
    }
}
