<?php

namespace Ds\Component\Security\EventListener\Token;

use Symfony\Component\HttpFoundation\RequestStack;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTDecodedEvent;

/**
 * Class ClientListener
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
    protected $client;

    /**
     * @var integer
     */
    protected $length;

    /**
     * Constructor
     *
     * @param \Symfony\Component\HttpFoundation\RequestStack $requestStack
     * @param boolean $validate
     * @param string $client
     * @param integer $length
     */
    public function __construct(RequestStack $requestStack, $validate = true, $client = 'cli', $length = 8)
    {
        $this->requestStack = $requestStack;
        $this->validate = $validate;
        $this->client = $client;
        $this->length = $length;
    }

    /**
     * On created
     *
     * @param \Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent $event
     */
    public function onCreated(JWTCreatedEvent $event)
    {
        $payload = $event->getData();
        $payload[$this->client] = $this->getIdentifier();
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

        if (!array_key_exists($this->client, $payload)) {
            $event->markAsInvalid();
        } elseif ($this->validate && $payload[$this->client] !== $this->getIdentifier()) {
            $event->markAsInvalid();
        }
    }

    /**
     * Get client identifier
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
