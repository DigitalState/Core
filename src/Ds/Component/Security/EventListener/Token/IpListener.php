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
     * @var \Symfony\Component\HttpFoundation\RequestStack
     */
    protected $requestStack;

    /**
     * @var boolean
     */
    protected $validate;

    /**
     * @var string
     */
    protected $ip;

    /**
     * Constructor
     *
     * @param \Symfony\Component\HttpFoundation\RequestStack $requestStack
     * @param boolean $validate
     * @param string $ip
     */
    public function __construct(RequestStack $requestStack, $validate = true, $ip = 'ip')
    {
        $this->requestStack = $requestStack;
        $this->validate = $validate;
        $this->ip = $ip;
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
        $payload[$this->ip] = $request->getClientIp();
        $event->setData($payload);
    }

    /**
     * On decoded
     *
     * @param \Lexik\Bundle\JWTAuthenticationBundle\Event\JWTDecodedEvent $event
     */
    public function onDecoded(JWTDecodedEvent $event)
    {
        $request = $this->requestStack->getCurrentRequest();
        $payload = $event->getPayload();

        if (!array_key_exists($this->ip, $payload)) {
            $event->markAsInvalid();
        } elseif ($this->validate && $payload[$this->ip] !== $request->getClientIp()) {
            $event->markAsInvalid();
        }
    }
}
