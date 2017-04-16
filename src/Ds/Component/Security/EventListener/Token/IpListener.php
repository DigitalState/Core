<?php

namespace Ds\Component\Security\EventListener\Token;

use Symfony\Component\HttpFoundation\RequestStack;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTDecodedEvent;

/**
 * Class IpListener
 */
class IpListener
{
    /**
     * @const string
     */
    const IP = 'ip';

    /**
     * @var \Symfony\Component\HttpFoundation\RequestStack
     */
    private $requestStack;

    /**
     * Constructor
     *
     * @param \Symfony\Component\HttpFoundation\RequestStack $requestStack
     */
    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    /**
     * On created
     *
     * @param \Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent $event
     */
    public function onCreated(JWTCreatedEvent $event)
    {
        $request = $this->requestStack->getCurrentRequest();
        $payload = $event->getData();
        $payload[static::IP] = $request->getClientIp();
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

        if (!array_key_exists(static::IP, $payload)) {
            $event->markAsInvalid();
        }
    }
}
