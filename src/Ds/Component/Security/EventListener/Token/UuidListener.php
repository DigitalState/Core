<?php

namespace Ds\Component\Security\EventListener\Token;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTDecodedEvent;
use Ds\Component\Security\Security\User\User;
use Ds\Component\Entity\Entity\Uuidentifiable;

/**
 * Class UuidListener
 */
class UuidListener
{
    /**
     * @const string
     */
    const UUID = 'uuid';

    /**
     * On created
     *
     * @param \Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent $event
     */
    public function onCreated(JWTCreatedEvent $event)
    {
        $payload = $event->getData();
        $user = $event->getUser();
        $payload[static::UUID] = $user->getUuid();
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

        if (!array_key_exists(static::UUID, $payload)) {
            $event->markAsInvalid();
        }
    }
}
