<?php

namespace Ds\Component\Tenant\EventListener\Token;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTDecodedEvent;

/**
 * Class TenantListener
 *
 * @package Ds\Component\Tenant
 */
class TenantListener
{
    /**
     * @var string
     */
    protected $attribute;

    /**
     * Constructor
     *
     * @param string $attribute
     */
    public function __construct($attribute = 'tenant')
    {
        $this->attribute = $attribute;
    }

    /**
     * Add the user tenant to the token
     *
     * @param \Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent $event
     * @throws \Ds\Component\Security\Exception\InvalidUserTypeException
     */
    public function created(JWTCreatedEvent $event)
    {
        $payload = $event->getData();
        $user = $event->getUser();
        $payload[$this->attribute] = $user->getTenant();
        $event->setData($payload);
    }

    /**
     * Mark the token as invalid if the user tenant is missing
     *
     * @param \Lexik\Bundle\JWTAuthenticationBundle\Event\JWTDecodedEvent $event
     */
    public function decoded(JWTDecodedEvent $event)
    {
        $payload = $event->getPayload();

        if (!array_key_exists($this->attribute, $payload)) {
            $event->markAsInvalid();
        }
    }
}
