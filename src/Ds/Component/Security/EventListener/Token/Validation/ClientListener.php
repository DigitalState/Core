<?php

namespace Ds\Component\Security\EventListener\Token\Validation;

use Symfony\Component\HttpFoundation\RequestStack;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTDecodedEvent;

/**
 * Class ClientListener
 */
class ClientListener
{
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
     * On decoded
     *
     * @param \Lexik\Bundle\JWTAuthenticationBundle\Event\JWTDecodedEvent $event
     */
    public function onDecoded(JWTDecodedEvent $event)
    {
        $payload = $event->getPayload();

        if (!array_key_exists('client', $payload)) {
            $event->markAsInvalid();
        }

        $request = $this->requestStack->getCurrentRequest();

        if ($payload['ip'] !== md5($request->server->get('HTTP_USER_AGENT'))) {
            $event->markAsInvalid();
        }
    }
}
