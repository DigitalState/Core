<?php

namespace Ds\Component\Security\EventListener\Token;

use Symfony\Component\HttpFoundation\RequestStack;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTDecodedEvent;

/**
 * Class IpListener
 *
 * @package Ds\Component\Security
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
    protected $attribute;

    /**
     * Constructor
     *
     * @param \Symfony\Component\HttpFoundation\RequestStack $requestStack
     * @param boolean $validate
     * @param string $attribute
     */
    public function __construct(RequestStack $requestStack, $validate = true, $attribute = 'ip')
    {
        $this->requestStack = $requestStack;
        $this->validate = $validate;
        $this->attribute = $attribute;
    }

    /**
     * Add the ip to the token
     *
     * @param \Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent $event
     */
    public function created(JWTCreatedEvent $event)
    {
        $request = $this->requestStack->getCurrentRequest();
        $payload = $event->getData();
        $payload[$this->attribute] = $request->getClientIp();
        $event->setData($payload);
    }

    /**
     * Mark the token as invalid if the ip is missing or is not valid
     *
     * @param \Lexik\Bundle\JWTAuthenticationBundle\Event\JWTDecodedEvent $event
     */
    public function decoded(JWTDecodedEvent $event)
    {
        $request = $this->requestStack->getCurrentRequest();
        $payload = $event->getPayload();

        if (!array_key_exists($this->attribute, $payload)) {
            $event->markAsInvalid();
        } elseif ($this->validate && $payload[$this->attribute] !== $request->getClientIp()) {
            $event->markAsInvalid();
        }
    }
}
