<?php

namespace Ds\Component\Security\EventListener\Token;

use Symfony\Component\HttpFoundation\RequestStack;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTDecodedEvent;

/**
 * Class ClientListener
 *
 * @package Ds\Component\Security
 */
class ClientListener
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
     * @var integer
     */
    protected $length;

    /**
     * Constructor
     *
     * @param \Symfony\Component\HttpFoundation\RequestStack $requestStack
     * @param boolean $validate
     * @param string $attribute
     * @param integer $length
     */
    public function __construct(RequestStack $requestStack, $validate = true, $attribute = 'cli', $length = 8)
    {
        $this->requestStack = $requestStack;
        $this->validate = $validate;
        $this->attribute = $attribute;
        $this->length = $length;
    }

    /**
     * Add the client identifier to the token
     *
     * @param \Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent $event
     */
    public function created(JWTCreatedEvent $event)
    {
        $payload = $event->getData();
        $payload[$this->attribute] = $this->getIdentifier();
        $event->setData($payload);
    }

    /**
     * Mark the token as invalid if the client identifier is missing or is not valid
     *
     * @param \Lexik\Bundle\JWTAuthenticationBundle\Event\JWTDecodedEvent $event
     */
    public function decoded(JWTDecodedEvent $event)
    {
        $payload = $event->getPayload();

        if (!array_key_exists($this->attribute, $payload)) {
            $event->markAsInvalid();
        } elseif ($this->validate && $payload[$this->attribute] !== $this->getIdentifier()) {
            $event->markAsInvalid();
        }
    }

    /**
     * Get the client identifier
     *
     * @return string
     */
    protected function getIdentifier()
    {
        $request = $this->requestStack->getCurrentRequest();
        $identifier = substr(md5($request->server->get('HTTP_USER_AGENT')), 0, $this->length);

        return $identifier;
    }
}
