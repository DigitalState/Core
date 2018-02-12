<?php

namespace Ds\Component\Security\EventListener\Token;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTDecodedEvent;

/**
 * Class IdentityListener
 *
 * @package Ds\Component\Security
 */
class IdentityListener
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
    public function __construct($attribute = 'identity')
    {
        $this->attribute = $attribute;
    }

    /**
     * Add the identity to the token
     *
     * @param \Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent $event
     * @throws \Ds\Component\Security\Exception\InvalidUserTypeException
     */
    public function created(JWTCreatedEvent $event)
    {
        $payload = $event->getData();
        $user = $event->getUser();
        $payload[$this->attribute] = $user->getIdentity();
        $event->setData($payload);
    }

    /**
     * Mark the token as invalid if the identity is missing
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
