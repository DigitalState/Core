<?php

namespace Ds\Component\Security\EventListener\Token;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTDecodedEvent;

/**
 * Class IdentityUuidListener
 */
class IdentityUuidListener
{
    /**
     * @var string
     */
    protected $identityUuid;

    /**
     * Constructor
     *
     * @param string $identityUuid
     */
    public function __construct($identityUuid = 'identityUuid')
    {
        $this->identityUuid = $identityUuid;
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
        $payload[$this->identityUuid] = $user->getIdentityUuid();
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

        if (!array_key_exists($this->identityUuid, $payload)) {
            $event->markAsInvalid();
        }
    }
}
