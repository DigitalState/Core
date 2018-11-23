<?php

namespace Ds\Component\Tenant\EventListener\Token;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTDecodedEvent;

/**
 * Class TenantListener
 *
 * @package Ds\Component\Tenant
 */
final class TenantListener
{
    /**
     * @var string
     */
    private $attribute;

    /**
     * Constructor
     *
     * @param string $attribute
     */
    public function __construct(string $attribute = 'tenant')
    {
        $this->attribute = $attribute;
    }

    /**
     * Add the user tenant to the token
     *
     * @param \Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent $event
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

        // Make property accessor paths compatible by converting payload to recursive associative array
        $payload = json_decode(json_encode($payload), true);

        if (!array_key_exists($this->attribute, $payload)) {
            $event->markAsInvalid();
        }
    }
}
