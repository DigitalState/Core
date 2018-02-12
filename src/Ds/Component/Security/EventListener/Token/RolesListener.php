<?php

namespace Ds\Component\Security\EventListener\Token;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTDecodedEvent;

/**
 * Class RolesListener
 *
 * @package Ds\Component\Security
 */
class RolesListener
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
    public function __construct($attribute = 'roles')
    {
        $this->attribute = $attribute;
    }

    /**
     * Add the user roles to the token
     *
     * @param \Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent $event
     * @throws \Ds\Component\Security\Exception\InvalidUserTypeException
     */
    public function created(JWTCreatedEvent $event)
    {
        $payload = $event->getData();

        // @todo

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
