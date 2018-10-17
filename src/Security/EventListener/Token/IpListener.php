<?php

namespace Ds\Component\Security\EventListener\Token;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTDecodedEvent;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * Class IpListener
 *
 * @package Ds\Component\Security
 */
class IpListener
{
    /**
     * @var \Symfony\Component\PropertyAccess\PropertyAccessor
     */
    protected $accessor;

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
    protected $property;

    /**
     * Constructor
     *
     * @param \Symfony\Component\HttpFoundation\RequestStack $requestStack
     * @param boolean $validate
     * @param string $property
     */
    public function __construct(RequestStack $requestStack, $validate = true, $property = '[ip]')
    {
        $this->accessor = PropertyAccess::createPropertyAccessor();
        $this->requestStack = $requestStack;
        $this->validate = $validate;
        $this->property = $property;
    }

    /**
     * Add the ip to the token
     *
     * @param \Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent $event
     */
    public function created(JWTCreatedEvent $event)
    {
        $request = $this->requestStack->getCurrentRequest();
        $data = $event->getData();
        $this->accessor->setValue($data, $this->property, $request->getClientIp());
        $event->setData($data);
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

        if (!$this->accessor->isReadable($payload, $this->property)) {
            $event->markAsInvalid();
        } elseif ($this->validate && $this->accessor->getValue($payload, $this->property) !== $request->getClientIp()) {
            $event->markAsInvalid();
        }
    }
}
