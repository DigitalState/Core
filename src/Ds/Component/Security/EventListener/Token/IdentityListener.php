<?php

namespace Ds\Component\Security\EventListener\Token;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTDecodedEvent;

/**
 * Class IdentityListener
 */
class IdentityListener
{
    /**
     * @var string
     */
    protected $identity;

    /**
     * Constructor
     *
     * @param string $identity
     */
    public function __construct($identity = 'identity')
    {
        $this->identity = $identity;
    }

    /**
     * On created
     *
     * @param \Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent $event
     * @throws \Ds\Component\Security\Exception\InvalidUserTypeException
     */
    public function onCreated(JWTCreatedEvent $event)
    {
        $payload = $event->getData();
        $user = $event->getUser();
        $payload[$this->identity] = $user->getIdentity();
        $event->setData($payload);
    }

    /**
     * On decoded
     *
     * @param \Lexik\Bundle\JWTAuthenticationBundle\Event\JWTDecodedEvent $event
     */
    public function onDecoded(JWTDecodedEvent $event)
    {
        $payload = $event->getPayload();

        if (!array_key_exists($this->identity, $payload)) {
            $event->markAsInvalid();
        }
    }
}
