<?php

namespace Ds\Component\Security\EventListener\Token;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTDecodedEvent;
use Ds\Component\Security\Security\User\User;
use Ds\Component\Entity\Entity\Uuidentifiable;

/**
 * Class IdentityListener
 */
class IdentityListener
{
    /**
     * @const string
     */
    const IDENTITY = 'identity';
    const IDENTITY_UUID = 'identity_uuid';

    /**
     * On created
     *
     * @param \Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent $event
     */
    public function onCreated(JWTCreatedEvent $event)
    {
        $payload = $event->getData();
        $user = $event->getUser();
        $payload[static::IDENTITY] = $user->getIdentity();
        $payload[static::IDENTITY_UUID] = $user->getIdentityUuid();
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

        if (!array_key_exists(static::IDENTITY, $payload)) {
            $event->markAsInvalid();
        }

        if (!array_key_exists(static::IDENTITY_UUID, $payload)) {
            $event->markAsInvalid();
        }
    }
}
