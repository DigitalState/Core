<?php

namespace Ds\Component\Security\EventListener\Token;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTDecodedEvent;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * Class ClientListener
 *
 * @package Ds\Component\Security
 */
final class ClientListener
{
    /**
     * @var \Symfony\Component\PropertyAccess\PropertyAccessor
     */
    private $accessor;

    /**
     * @var \Symfony\Component\HttpFoundation\RequestStack
     */
    private $requestStack;

    /**
     * @var boolean
     */
    private $validate;

    /**
     * @var string
     */
    private $property;

    /**
     * @var integer
     */
    private $length;

    /**
     * Constructor
     *
     * @param \Symfony\Component\HttpFoundation\RequestStack $requestStack
     * @param boolean $validate
     * @param string $property
     * @param integer $length
     */
    public function __construct(RequestStack $requestStack, bool $validate = true, string $property = '[client]', int $length = 8)
    {
        $this->accessor = PropertyAccess::createPropertyAccessor();
        $this->requestStack = $requestStack;
        $this->validate = $validate;
        $this->property = $property;
        $this->length = $length;
    }

    /**
     * Add the client signature to the token
     *
     * @param \Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent $event
     */
    public function created(JWTCreatedEvent $event)
    {
        $data = $event->getData();
        $this->accessor->setValue($data, $this->property, $this->getSignature());
        $event->setData($data);
    }

    /**
     * Mark the token as invalid if the client signature is missing or is not matching
     *
     * @param \Lexik\Bundle\JWTAuthenticationBundle\Event\JWTDecodedEvent $event
     */
    public function decoded(JWTDecodedEvent $event)
    {
        $payload = $event->getPayload();

        if (!$this->accessor->isReadable($payload, $this->property)) {
            $event->markAsInvalid();
        } elseif ($this->validate && $this->accessor->getValue($payload, $this->property) !== $this->getSignature()) {
            $event->markAsInvalid();
        }
    }

    /**
     * Get the client signature
     *
     * @return string
     */
    protected function getSignature(): string
    {
        $request = $this->requestStack->getCurrentRequest();
        $signature = substr(md5($request->server->get('HTTP_USER_AGENT')), 0, $this->length);

        return $signature;
    }
}
